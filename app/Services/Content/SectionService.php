<?php

namespace App\Services\Content;

use App\Models\Content\Section;
use App\Services\IndexUrlService;
use App\Services\LanguageService;
use App\Services\Master\Field\FieldCategoryService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SectionService
{
    private $model, $lang, $field, $index;

    public function __construct(
        Section $model,
        LanguageService $lang,
        FieldCategoryService $field,
        IndexUrlService $index
    )
    {
        $this->model = $model;
        $this->lang = $lang;
        $this->field = $field;
        $this->index = $index;
    }

    public function getSectionList($request)
    {
        $query = $this->model->query();

        $query->when($request, function ($query, $req) {
            if ($req->e != '') {
                $query->where('extra', $req->e);
            }
        })->when($request, function ($query, $req) {
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

        $result = $query->orderBy('position', 'ASC')->paginate($limit);

        return $result;
    }

    public function getSection($request = null, $withPaginate = null, $limit = null)
    {
        $query = $this->model->query();

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
                    ->orWhere('description->'.App::getLocale(), 'like', '%'.$q.'%');
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

    public function store($request)
    {
        $section = new Section;
        $this->setField($request, $section);
        $section->position = $this->model->max('position') + 1;
        $section->created_by = Auth::user()->id;
        $section->save();

        $slug = Str::limit(Str::slug($request->slug, '-'), 50);
        $this->index->store($slug, $section);

        return $section;
    }

    public function update($request, int $id)
    {
        $section = $this->find($id);
        $this->setField($request, $section);
        $section->updated_by = Auth::user()->id;
        $section->save();

        $slug = Str::limit(Str::slug($request->slug, '-'), 50);
        $this->index->update($request->url_id, $slug);

        return $section;
    }

    public function setField($request, $section)
    {
        foreach ($this->lang->getLang(false, true) as $key => $value) {
            $name[$value->iso_codes] = ($request->input('name_'.$value->iso_codes) == null) ?
                $request->input('name_'.config('custom.language.default')) : $request->input('name_'.$value->iso_codes);
            $description[$value->iso_codes] = ($request->input('description_'.$value->iso_codes) == null) ?
                $request->input('description_'.config('custom.language.default')) : $request->input('description_'.$value->iso_codes);
        }

        $section->slug = Str::limit(Str::slug($request->slug, '-'), 50);
        $section->name = $name;
        $section->description = $description;
        $section->public = (bool)$request->public;
        $section->order_field = $request->order_field ?? 4;
        $section->order_by = $request->order_by ?? 'DESC';
        $section->extra = $request->extra ?? null;
        $section->list_view_id = $request->list_view_id ?? null;
        $section->detail_view_id = $request->detail_view_id ?? null;
        $section->limit_category = $request->limit_category ?? null;
        $section->limit_post = $request->limit_post ?? null;
        $section->post_selection = $request->post_selection ?? null;
        $section->is_detail = (bool)$request->is_detail;
        $section->banner = [
            'file_path' => Str::replace(url('storage/'), '', $request->banner_file) ?? null,
            'title' => $request->banner_title ?? null,
            'alt' => $request->banner_alt ?? null,
        ];
        $section->field_category_id = $request->field_category_id ?? null;
        if (!empty($request->field_category_id)) {

            $field = $this->field->find($request->field_category_id);
            foreach ($field->fields as $key => $value) {
                $custom_field[$key] = [
                    $value->name => $request->input('field_'.$value->name) ?? null
                ];
            }

            $section->custom_field = $custom_field;

        } else {
            $section->custom_field = null;
        }

        return $section;
    }

    public function position(int $id, int $position)
    {
        if ($position >= 1) {

            $section = $this->find($id);
            $this->model->where('position', $position)->update([
                'position' => $section->position,
            ]);
            $section->position = $position;
            $section->updated_by = Auth::user()->id;
            $section->save();

            return $section;
        }
    }

    public function recordViewer(int $id)
    {
        $section = $this->find($id);
        $section->viewer = ($section->viewer+1);
        $section->save();

        return $section;
    }

    public function delete(int $id)
    {
        $section = $this->find($id);

        $category = $section->categories->count();
        $post = $section->posts->count();
        $menu = $section->menu()->count();

        if ($category == 0 && $post == 0 && $menu == 0) {

            $section->indexing->delete();
            $section->delete();
            return true;

        } else {
            return false;
        }
    }
}