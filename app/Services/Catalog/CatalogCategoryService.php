<?php

namespace App\Services\Catalog;

use App\Models\Catalog\CatalogCategory;
use App\Services\LanguageService;
use App\Services\Master\Field\FieldCategoryService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CatalogCategoryService
{
    private $model, $lang, $field;

    public function __construct(
        CatalogCategory $model,
        LanguageService $lang,
        FieldCategoryService $field
    )
    {
        $this->model = $model;
        $this->lang = $lang;
        $this->field = $field;
    }

    public function getCatalogCategoryList($request)
    {
        $query = $this->model->query();

        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('name->'.App::getLocale(), 'like', '%'.$q.'%');
            });
        });

        $limit = 20;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->orderBy('position', 'ASC')->paginate($limit);

        return $result;
    }

    public function getCatalogCategory($request = null, $withPaginate = null, $limit = null)
    {
        $query = $this->model->query();

        if (!empty($request)) {
            $query->when($request->keyword, function ($query, $q) {
                $query->where(function ($query) use ($q) {
                    $query->where('name->'.App::getLocale(), 'like', '%'.$q.'%')
                        ->orWhere('meta_data->title', 'like', '%'.$q.'%')
                        ->orWhere('meta_data->description', 'like', '%'.$q.'%')
                        ->orWhere('meta_data->keywords', 'like', '%'.$q.'%');
                });
            });
        }

        $query->orderBy('position', 'ASC');
        if (!empty($withPaginate)) {
            $result = $query->paginate($limit);
        } else {
            if (!empty($limit)) {
                $result = $query->limit($limit)->get();
            } else {
                $result = $query->get();
            }
        }

        return $result;
    }

    public function countCatalogCategory()
    {
        $query = $this->model->query();

        $result = $query->count();

        return $result;
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function findBySlug($slug)
    {
        $query = $this->model->query();

        $query->where('slug', $slug);
        $result = $query->first();

        return $result;
    }

    public function store($request)
    {
        $category = new CatalogCategory;
        $this->setField($request, $category);
        $category->position = $this->model->max('position') + 1;
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

        $category->slug = Str::limit(Str::slug($request->slug, '-'), 50);
        $category->name = $name;
        $category->description = $description;
        $category->cover = [
            'file_path' => Str::replace(url('/storage'), '', $request->cover_file) ?? null,
            'title' => $request->cover_title ?? null,
            'alt' => $request->cover_alt ?? null,
        ];
        $category->banner = [
            'file_path' => Str::replace(url('/storage'), '', $request->banner_file) ?? null,
            'title' => $request->banner_title ?? null,
            'alt' => $request->banner_alt ?? null,
        ];
        $category->is_detail = (bool)$request->is_detail;
        $category->product_limit = $request->product_limit ?? null;
        $category->product_selection = $request->product_selection ?? null;
        $category->custom_view_id = $request->custom_view_id ?? null;
        $category->meta_data = [
            'title' => $request->meta_title ?? null,
            'description' => $request->meta_description ?? null,
            'keywords' => $request->meta_keywords ?? null,
        ];

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

    public function position(int $id, int $position)
    {
        if ($position >= 1) {

            $category = $this->find($id);
            $this->model->where('position', $position)->update([
                'position' => $category->position,
            ]);
            $category->position = $position;
            $category->updated_by = Auth::user()->id;
            $category->save();

            return $category;
        }
    }

    public function recordViewer(int $id)
    {
        $category = $this->find($id);
        $category->viewer = ($category->viewer+1);
        $category->save();

        return $category;
    }

    public function delete(int $id)
    {
        $category = $this->find($id);

        $product = $category->products->count();

        if ($product == 0 && $category->menu()->count() == 0) {

            $category->delete();
            return true;

        } else {

            return false;
        }
    }
}