<?php

namespace App\Services\Page;

use App\Models\Page\Page;
use App\Services\IndexUrlService;
use App\Services\LanguageService;
use App\Services\Master\Field\FieldCategoryService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PageService
{
    private $model, $lang, $field, $index;

    public function __construct(
        Page $model,
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

    public function getPageList($request)
    {
        $query = $this->model->query();

        $query->when($request, function ($query, $req) {
            if ($req->s != '') {
                $query->where('publish', $req->s);
            }
        })->when($request, function ($query, $req) {
            if ($req->p != '') {
                $query->where('public', $req->p);
            }
        })->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('title->'.App::getLocale(), 'like', '%'.$q.'%');
            });
        });

        $limit = 20;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->where('parent', 0)->orderBy('position', 'ASC')->paginate($limit);

        return $result;
    }

    public function getPage($request = null, $withPaginate = null, $limit = null)
    {
        $query = $this->model->query();

        $query->publish();
        if (Auth::guard()->check() == false) {
            $query->public();
        }

        if (!empty($request)) {
            $this->search($query, $request);
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

    public function search($query, $request)
    {
        $query->when($request->keyword, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('title->'.App::getLocale(), 'like', '%'.$q.'%')
                    ->orWhere('intro->'.App::getLocale(), 'like', '%'.$q.'%')
                    ->orWhere('content->'.App::getLocale(), 'like', '%'.$q.'%')
                    ->orWhere('meta_data->title', 'like', '%'.$q.'%')
                    ->orWhere('meta_data->description', 'like', '%'.$q.'%')
                    ->orWhere('meta_data->keywords', 'like', '%'.$q.'%');
            });
        });
    }

    public function count()
    {
        $query = $this->model->query();

        $query->publish();

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
        $parent = $request->parent ?? 0;

        $page = new Page;
        $page->parent = $parent;
        $this->setField($request, $page);
        $page->position = $this->model->where('parent', (int)$parent)->max('position') + 1;
        $page->created_by = Auth::user()->id;
        $page->save();
        
        $slug = Str::limit(Str::slug($request->slug, '-'), 50);
        $this->index->store($slug, $page);

        return $page;
    }

    public function update($request, int $id)
    {
        $page = $this->find($id);
        $this->setField($request, $page);
        $page->updated_by = Auth::user()->id;
        $page->save();

        $slug = Str::limit(Str::slug($request->slug, '-'), 50);
        $this->index->update($request->url_id, $slug);

        return $page;
    }

    public function setField($request, $page)
    {
        //lang
        foreach ($this->lang->getLang(false, true) as $key => $value) {
            $title[$value->iso_codes] = ($request->input('title_'.$value->iso_codes) == null) ?
                $request->input('title_'.config('custom.language.default')) : $request->input('title_'.$value->iso_codes);
            $intro[$value->iso_codes] = ($request->input('intro_'.$value->iso_codes) == null) ?
                $request->input('intro_'.config('custom.language.default')) : $request->input('intro_'.$value->iso_codes);
            $content[$value->iso_codes] = ($request->input('content_'.$value->iso_codes) == null) ?
                $request->input('content_'.config('custom.language.default')) : $request->input('content_'.$value->iso_codes);
        }

        $page->slug = Str::limit(Str::slug($request->slug, '-'), 50);
        $page->title = $title;
        $page->intro = $intro;
        $page->content = $content;
        $page->cover = [
            'file_path' => Str::replace(url('/storage'), '', $request->cover_file) ?? null,
            'title' => $request->cover_title ?? null,
            'alt' => $request->cover_alt ?? null,
        ];

        $page->banner = [
            'file_path' => Str::replace(url('/storage'), '', $request->banner_file) ?? null,
            'title' => $request->banner_title ?? null,
            'alt' => $request->banner_alt ?? null,
        ];

        $page->publish = (bool)$request->publish;
        $page->public = (bool)$request->public;
        $page->custom_view_id = $request->custom_view_id ?? null;
        $page->is_detail = (bool)$request->is_detail;
        $page->meta_data = [
            'title' => $request->meta_title ?? null,
            'description' => $request->meta_description ?? null,
            'keywords' => $request->meta_keywords ?? null,
        ];

        $page->field_category_id = $request->field_category_id ?? null;
        if (!empty($request->field_category_id)) {

            $field = $this->field->find($request->field_category_id);
            foreach ($field->fields as $key => $value) {
                $custom_field[$key] = [
                    $value->name => $request->input('field_'.$value->name) ?? null
                ];
            }

            $page->custom_field = $custom_field;
        } else {
            $page->custom_field = null;
        }

        return $page;
    }

    public function publish(int $id)
    {
        $page = $this->find($id);
        $page->publish = !$page->publish;
        $page->updated_by = Auth::user()->id;
        $page->save();

        return $page;
    }

    public function position(int $id, int $position, int $parent = null)
    {
        if ($position >= 1) {

            $page = $this->find($id);

            if ($parent != null) {
                $this->model->where('position', $position)->where('parent', $parent)->update([
                    'position' => $page->position,
                ]);
            } else {
                $this->model->where('position', $position)->where('parent', 0)->update([
                    'position' => $page->position,
                ]);
            }

            $page->position = $position;
            $page->updated_by = Auth::user()->id;
            $page->save();

            return $page;
        }
    }

    public function recordViewer(int $id)
    {
        $page = $this->find($id);
        $page->viewer = ($page->viewer+1);
        $page->save();

        return $page;
    }

    public function delete(int $id)
    {
        $page = $this->find($id);

        $parent = $this->model->where('parent', $id)->count();
        $menu = $page->menu()->count();

        if ($parent == 0 && $menu == 0) {

            foreach ($this->model->where('parent', $id)->get() as $valueA) {

                $valueA->media()->delete();
                $valueA->indexing->delete();
                $valueA->delete();

                foreach ($this->model->where('parent', $valueA->id)->get() as $valueB) {

                    $valueB->media()->delete();
                    $valueB->indexing->delete();
                    $valueB->delete();
                }
            }

            $page->media()->delete();
            $page->indexing->delete();
            $page->delete();

            return true;

        } else {

            return false;
            
        }
    }
}