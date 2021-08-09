<?php

namespace App\Services\Banner;

use App\Models\Banner\BannerCategory;
use App\Services\LanguageService;
use App\Services\Master\Field\FieldCategoryService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BannerCategoryService
{
    private $model, $lang, $field;

    public function __construct(
        BannerCategory $model,
        LanguageService $lang,
        FieldCategoryService $field
    )
    {
        $this->model = $model;
        $this->lang = $lang;
        $this->field = $field;
    }

    public function getBannerCategoryList($request)
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

    public function getBannerCategory($id)
    {
        $query = $this->model->query();

        $query->where('id', $id);

        $result = $query->get();

        return $result;
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function store($request)
    {
        $category = new BannerCategory;
        $this->setField($request, $category);
        $category->created_by = Auth::user()->id;
        $category->save();

        return $category;
    }

    public function update($request, int $id)
    {
        $category = $this->find($id);
        $this->setField($request, $category);
        $category->updated_by = Auth::user()->id;
        $category->save();

        return $category;
    }

    public function setField($request, $category)
    {
        foreach ($this->lang->getLang(false, true) as $key => $value) {
            $name[$value->iso_codes] = ($request->input('name_'.$value->iso_codes) == null) ?
                $request->input('name_'.config('custom.language.default')) : $request->input('name_'.$value->iso_codes);
            $description[$value->iso_codes] = ($request->input('description_'.$value->iso_codes) == null) ?
                $request->input('description_'.config('custom.language.default')) : $request->input('description_'.$value->iso_codes);
        }

        $category->name = $name;
        $category->description = $description;
        $category->banner_limit = $request->banner_limit ?? null;

        $category->field_category_id = $request->field_category_id ?? null;
        if (!empty($request->field_category_id)) {

            $field = $this->field->find($request->field_category_id);
            foreach ($field->fields as $key => $value) {
                $custom_field[$key] = [
                    $value->name => $request->input('field_'.$value->name) ?? null
                ];
            }

            $category->custom_field = $custom_field;

        } else {
            $category->custom_field = null;
        }

        return $category;
    }

    public function delete(int $id)
    {
        $category = $this->find($id);

        $banner = $category->banners->count();

        if ($banner == 0) {

            Storage::deleteDirectory(config('custom.files.banner.path').$id);
            Storage::deleteDirectory(config('custom.files.banner.thumbnail.path').$id);
            $category->field()->delete();
            $category->delete();

            return true;

        } else {
            return false;
        }
    }
}