<?php

namespace App\Services\Link;

use App\Models\Link\Link;
use App\Services\IndexUrlService;
use App\Services\LanguageService;
use App\Services\Master\Field\FieldCategoryService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LinkService
{
    private $model, $lang, $field, $index;

    public function __construct(
        Link $model,
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

    public function getLinkList($request)
    {
        $query = $this->model->query();

        $query->when($request, function ($query, $req) {
            if ($req->s != '') {
                $query->where('publish', $req->s);
            }
        })->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('name->'.App::getLocale(), 'like', '%'.$q.'%');
            });
        });

        $limit = 6;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->orderBy('position', 'ASC')->paginate($limit);

        return $result;
    }

    public function getLink($request = null, $withPaginate = null, $limit = null)
    {
        $query = $this->model->query();

        $query->publish();

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
        $link = new Link;
        $this->setField($request, $link);
        $link->position = $this->model->max('position') + 1;
        $link->created_by = Auth::user()->id;
        $link->save();

        $slug = Str::limit(Str::slug($request->slug, '-'), 50);
        $this->index->store($slug, $link);

        return $link;
    }

    public function update($request, int $id)
    {
        $link = $this->find($id);
        $this->setField($request, $link);
        $link->updated_by = Auth::user()->id;
        $link->save();

        $slug = Str::limit(Str::slug($request->slug, '-'), 50);
        $this->index->update($request->url_id, $slug);

        return $link;
    }

    public function setField($request, $link)
    {
        foreach ($this->lang->getLang(false, true) as $key => $value) {
            $name[$value->iso_codes] = ($request->input('name_'.$value->iso_codes) == null) ?
                $request->input('name_'.config('custom.language.default')) : $request->input('name_'.$value->iso_codes);
            $description[$value->iso_codes] = ($request->input('description_'.$value->iso_codes) == null) ?
                $request->input('description_'.config('custom.language.default')) : $request->input('description_'.$value->iso_codes);
        }

        $link->slug = Str::limit(Str::slug($request->slug, '-'), 50);
        $link->name = $name;
        $link->description = $description;
        $link->publish = (bool)$request->publish;
        $link->is_detail = (bool)$request->is_detail;
        $link->custom_view_id = $request->custom_view_id ?? null;
        $link->media_limit = $request->media_limit ?? null;
        $link->cover = [
            'file_path' => str_replace(url('/storage'), '', $request->cover_file) ?? null,
            'title' => $request->cover_title ?? null,
            'alt' => $request->cover_alt ?? null,
        ];
        $link->banner = [
            'file_path' => str_replace(url('/storage'), '', $request->banner_file) ?? null,
            'title' => $request->banner_title ?? null,
            'alt' => $request->banner_alt ?? null,
        ];
        $link->meta_data = [
            'title' => $request->meta_title ?? null,
            'description' => $request->meta_description ?? null,
            'keywords' => $request->meta_keywords ?? null,
        ];

        $link->field_category_id = $request->field_category_id ?? null;
        if (!empty($request->field_category_id)) {

            $field = $this->field->find($request->field_category_id);
            foreach ($field->fields as $key => $value) {
                $custom_field[$key] = [
                    $value->name => $request->input('field_'.$value->name) ?? null
                ];
            }

            $link->custom_field = $custom_field;
        } else {
            $link->custom_field = null;
        }

        return $link;
    }

    public function publish(int $id)
    {
        $link = $this->find($id);
        $link->publish = !$link->publish;
        $link->updated_by = Auth::user()->id;
        $link->save();

        return $link;
    }

    public function position(int $id, int $position)
    {
        if ($position >= 1) {

            $link = $this->find($id);
            $this->model->where('position', $position)->update([
                'position' => $link->position,
            ]);
            $link->position = $position;
            $link->updated_by = Auth::user()->id;
            $link->save();

            return $link;
        }
    }

    public function recordViewer(int $id)
    {
        $link = $this->find($id);
        $link->viewer = ($link->viewer+1);
        $link->save();

        return $link;
    }

    public function delete(int $id)
    {
        $link = $this->find($id);

        if ($link->medias->count() == 0 && $link->menu()->count() == 0) {

            $link->indexing->delete();
            $link->delete();

            return true;

        } else {
            return false;
        }

    }
}