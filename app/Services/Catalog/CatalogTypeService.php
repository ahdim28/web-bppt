<?php

namespace App\Services\Catalog;

use App\Models\Catalog\CatalogType;
use App\Services\LanguageService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class CatalogTypeService
{
    private $model, $lang;

    public function __construct(
        CatalogType $model,
        LanguageService $lang
    )
    {
        $this->model = $model;
        $this->lang = $lang;
    }

    public function getCatalogTypeList($request)
    {
        $query = $this->model->query();

        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('name->'.App::getLocale(), 'like', '%'.$q.'%')
                    ->orWhere('description->'.App::getLocale(), 'like', '%'.$q.'%');
            });
        });

        $limit = 20;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->paginate($limit);

        return $result;
    }

    public function getCatalogType()
    {
        $query = $this->model->query();

        $result = $query->get();

        return $result;
    }

    public function countCatalogType()
    {
        $query = $this->model->query();

        $result = $query->count();

        return $result;
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function store($request)
    {
        $type = new CatalogType;
        $this->setField($request, $type);
        $type->created_by = Auth::user()->id;
        $type->save();

        return $type;
    }

    public function update($request, int $id)
    {
        $type = $this->find($id);
        $this->setField($request, $type);
        $type->updated_by = Auth::user()->id;
        $type->save();

        return $type;
    }

    public function setField($request, $type)
    {
        foreach ($this->lang->getLang(false, true) as $key => $value) {
            $name[$value->iso_codes] = ($request->input('name_'.$value->iso_codes) == null) ?
                $request->input('name_'.config('custom.language.default')) : $request->input('name_'.$value->iso_codes);
            $description[$value->iso_codes] = ($request->input('description_'.$value->iso_codes) == null) ?
                $request->input('description_'.config('custom.language.default')) : $request->input('description_'.$value->iso_codes);
        }

        $type->name = $name;
        $type->description = $description;

        return $type;
    }

    public function delete(int $id)
    {
        $type = $this->find($id);

        $product = $type->products->count();
        
        if ($product == 0) {

            $type->delete();
            return true;

        } else {

            return false;
            
        }
    }
}