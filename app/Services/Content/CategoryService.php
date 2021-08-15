<?php

namespace App\Services\Content;

use App\Models\Content\Category;
use App\Services\LanguageService;
use App\Services\Master\Field\FieldCategoryService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryService
{
    private $model, $lang, $field;

    public function __construct(
        Category $model,
        LanguageService $lang,
        FieldCategoryService $field
    )
    {
        $this->model = $model;
        $this->lang = $lang;
        $this->field = $field;
    }

    public function getCategoryList($request, int $sectionId)
    {
        $query = $this->model->query();

        $query->where('section_id', $sectionId);
        $query->when($request, function ($query, $req) {
            if ($req->p != '') {
                $query->where('public', $req->p);
            }
        })->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('name->'.App::getLocale(), 'like', '%'.$q.'%');
            });
        });

        $limit = 20;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->where('parent', 0)->orderBy('position', 'ASC')->paginate($limit);

        return $result;
    }

    public function getCategoryBySection($sectionId)
    {
        $query = $this->model->query();

        if (!empty($sectionId)) {
            $query->where('section_id', $sectionId);
        }

        $result = $query->get();

        return $result;
    }

    public function getCategory($request = null, $withPaginate = null, 
        $limit = null, int $sectionId = nullz)
    {
        $query = $this->model->query();

        if (!empty($sectionId)) {
            $query->where('section_id', $sectionId);
        }

        if (Auth::guard()->check() == false) {
            $query->public();
        }

        if (!empty($request)) {
            $this->search($query, $request);
        }

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

    public function search($query, $request)
    {
        $query->when($request->keyword, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('name->'.App::getLocale(), 'like', '%'.$q.'%')
                    ->orWhere('description->'.App::getLocale(), 'like', '%'.$q.'%');;
            });
        });
    }

    public function count()
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

    public function store($request, int $sectionId)
    {
        $parent = $request->parent ?? 0;
        
        $category = new Category;
        $category->section_id = $sectionId;
        $category->parent = $parent;
        $this->setField($request, $category);
        $category->position = $this->model->where('section_id', $sectionId)
            ->where('parent', (int)$parent)
            ->max('position') + 1;
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
        $category->public = (bool)$request->public;
        $category->is_detail = (bool)$request->is_detail;
        $category->list_view_id = $request->list_view_id ?? null;
        $category->detail_view_id = $request->detail_view_id?? null;
        $category->list_limit = $request->list_limit ?? null;
        $category->banner = [
            'file_path' => Str::replace(url('storage/'), '', $request->banner_file) ?? null,
            'title' => $request->banner_title ?? null,
            'alt' => $request->banner_alt ?? null,
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

    public function position(int $id, int $position, int $parent = null)
    {
        if ($position >= 1) {

            $category = $this->find($id);

            if ($parent != null) {
                $this->model->where('section_id', $category->section_id)
                    ->where('position', $position)->where('parent', $parent)->update([
                    'position' => $category->position,
                ]);
            } else {
                $this->model->where('section_id', $category->section_id)
                    ->where('position', $position)->where('parent', 0)->update([
                    'position' => $category->position,
                ]);
            }

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

        $parent = $this->model->where('parent', $id)->count();
        $post = $category->posts->count();
        $menu = $category->menu()->count();

        if ($parent == 0 && $post == 0 && $menu == 0) {

            foreach ($this->model->where('parent', $id)->get() as $valueA) {

                $valueA->delete();

                foreach ($this->model->where('parent', $valueA->id)->get() as $valueB) {

                    $valueB->delete();
                }
            }

            $category->delete();
            return true;

        } else {
            return false;
        }
    }
}