<?php

namespace App\Services\Gallery;

use App\Models\Gallery\AlbumCategory;
use App\Services\LanguageService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AlbumCategoryService
{
    private $model, $lang;

    public function __construct(
        AlbumCategory $model,
        LanguageService $lang
    )
    {
        $this->model = $model;
        $this->lang = $lang;
    }

    public function getAlbumCategoryList($request)
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

        $result = $query->orderBy('position', 'ASC')->paginate($limit);

        return $result;
    }

    public function getAlbumCategory($request = null, $withPaginate = false, $limit = false)
    {
        $query = $this->model->query();

        if (!empty($request)) {
            $query->when($request->q, function ($query, $q) {
                $query->where(function ($query) use ($q) {
                    $query->where('name->'.App::getLocale(), 'like', '%'.$q.'%')
                        ->orWhere('description->'.App::getLocale(), 'like', '%'.$q.'%');
                });
            });
        }

        if (!empty($withPaginate)) {
            $result = $query->orderBy('position', 'ASC')->paginate($limit);
        } else {
            if (!empty($limit)) {
                $result = $query->orderBy('position', 'ASC')->limit($limit)->get();
            } else {
                $result = $query->orderBy('position', 'ASC')->get();
            }
        }

        return $result;
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function store($request)
    {
        $alCat = new AlbumCategory;
        $alCat->position = $this->model->max('position') + 1;
        $this->setField($request, $alCat);
        $alCat->created_by = Auth::user()->id;
        $alCat->save();

        return $alCat;
    }

    public function update($request, int $id)
    {
        $alCat = $this->find($id);
        $this->setField($request, $alCat);
        $alCat->updated_by = Auth::user()->id;
        $alCat->save();

        return $alCat;
    }

    public function setField($request, $alCat)
    {
        foreach ($this->lang->getLang(false, true) as $key => $value) {
            $name[$value->iso_codes] = ($request->input('name_'.$value->iso_codes) == null) ?
                $request->input('name_'.config('custom.language.default')) : $request->input('name_'.$value->iso_codes);
            $description[$value->iso_codes] = ($request->input('description_'.$value->iso_codes) == null) ?
                $request->input('description_'.config('custom.language.default')) : $request->input('description_'.$value->iso_codes);
        }

        $alCat->slug = Str::limit(Str::slug($request->slug, '-'), 50);
        $alCat->name = $name;
        $alCat->description = $description;

        return $alCat;
    }

    public function position(int $id, int $position)
    {
        if ($position >= 1) {

            $alCat = $this->find($id);
            $this->model->where('position', $position)->update([
                'position' => $alCat->position,
            ]);
            $alCat->position = $position;
            $alCat->updated_by = Auth::user()->id;
            $alCat->save();

            return $alCat;
        }
    }

    public function delete(int $id)
    {
        $alCat = $this->find($id);

        $album = $alCat->albums->count();
        
        if ($album == 0) {

            $alCat->delete();
            return true;

        } else {

            return false;
            
        }
    }
}