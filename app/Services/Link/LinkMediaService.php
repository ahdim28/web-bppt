<?php

namespace App\Services\Link;

use App\Models\Link\LinkMedia;
use App\Services\LanguageService;
use App\Services\Master\Field\FieldCategoryService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LinkMediaService
{
    private $model, $lang, $field;

    public function __construct(
        LinkMedia $model,
        LanguageService $lang,
        FieldCategoryService $field
    )
    {
        $this->model = $model;
        $this->lang = $lang;
        $this->field = $field;
    }

    public function getLinkMediaList($request, $linkId)
    {
        $query = $this->model->query();

        $query->where('link_id', $linkId);
        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('title->'.App::getLocale(), 'like', '%'.$q.'%')
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

    public function getLinkMedia($request = null, $withPaginate = null, $limit = null, 
        $linkId = null)
    {
        $query = $this->model->query();

        if (!empty($linkId)) {
            $query->where('link_id', $linkId);
        }

        if (!empty($request)) {
            $query->when($request->q, function ($query, $q) {
                $query->where(function ($query) use ($q) {
                    $query->where('title->'.App::getLocale(), 'like', '%'.$q.'%')
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

    public function countLinkMedia()
    {
        $query = $this->model->query();

        $result = $query->count();

        return $result;
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function store($request, int $linkId)
    {
        $linkMedia = new LinkMedia;
        $linkMedia->link_id = $linkId;
        $this->setField($request, $linkMedia);
        $linkMedia->position = $this->model->where('link_id', $linkId)->max('position') + 1;
        $linkMedia->created_by = Auth::user()->id;
        $linkMedia->save();

        return $linkMedia;
    }

    public function update($request, int $id)
    {
        $linkMedia = $this->find($id);
        $this->setField($request, $linkMedia);
        $linkMedia->updated_by = Auth::user()->id;
        $linkMedia->save();

        return $linkMedia;
    }

    public function setField($request, $linkMedia)
    {
        foreach ($this->lang->getLang(false, true) as $key => $value) {
            $title[$value->iso_codes] = ($request->input('title_'.$value->iso_codes) == null) ?
                $request->input('title_'.config('custom.language.default')) : $request->input('title_'.$value->iso_codes);
            $description[$value->iso_codes] = ($request->input('description_'.$value->iso_codes) == null) ?
                $request->input('description_'.config('custom.language.default')) : $request->input('description_'.$value->iso_codes);
        }

        $linkMedia->title = $title;
        $linkMedia->description = $description;
        $linkMedia->url = $request->url;
        $linkMedia->cover = [
            'file_path' => str_replace(url('/storage'), '', $request->cover_file) ?? null,
            'title' => $request->cover_title ?? null,
            'alt' => $request->cover_alt ?? null,
        ];
        $linkMedia->banner = [
            'file_path' => str_replace(url('/storage'), '', $request->banner_file) ?? null,
            'title' => $request->banner_title ?? null,
            'alt' => $request->banner_alt ?? null,
        ];

        $linkMedia->field_category_id = $request->field_category_id ?? null;
        if (!empty($request->field_category_id)) {

            $field = $this->field->find($request->field_category_id);
            foreach ($field->fields as $key => $value) {
                $custom_field[$key] = [
                    $value->name => $request->input('field_'.$value->name) ?? null
                ];
            }

            $linkMedia->custom_field = $custom_field;
        } else {
            $linkMedia->custom_field = null;
        }

        return $linkMedia;
    }

    public function position(int $id, int $position)
    {
        if ($position >= 1) {

            $linkMedia = $this->find($id);
            $this->model->where('position', $position)->update([
                'position' => $linkMedia->position,
            ]);
            $linkMedia->position = $position;
            $linkMedia->updated_by = Auth::user()->id;
            $linkMedia->save();

            return $linkMedia;
        }
    }

    public function delete(int $id)
    {
        $linkMedia = $this->find($id);
        $linkMedia->delete();

        return true;
    }
}