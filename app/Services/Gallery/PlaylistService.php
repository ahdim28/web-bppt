<?php

namespace App\Services\Gallery;

use App\Models\Gallery\Playlist;
use App\Services\LanguageService;
use App\Services\Master\Field\FieldCategoryService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PlaylistService
{
    private $model, $lang, $field;

    public function __construct(
        Playlist $model,
        LanguageService $lang,
        FieldCategoryService $field
    )
    {
        $this->model = $model;
        $this->lang = $lang;
        $this->field = $field;
    }

    public function getPlaylistList($request)
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

    public function getPlaylist($request = null, $withPaginate = null, $limit = null)
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
        $playlist = new Playlist;
        $this->setField($request, $playlist);
        $playlist->position = $this->model->max('position') + 1;
        $playlist->created_by = Auth::user()->id;
        $playlist->save();

        return $playlist;
    }

    public function update($request, int $id)
    {
        $playlist = $this->find($id);
        $this->setField($request, $playlist);
        $playlist->updated_by = Auth::user()->id;
        $playlist->save();

        return $playlist;
    }

    public function setField($request, $playlist)
    {
        foreach ($this->lang->getLang(false, true) as $key => $value) {
            $name[$value->iso_codes] = ($request->input('name_'.$value->iso_codes) == null) ?
                $request->input('name_'.config('custom.language.default')) : $request->input('name_'.$value->iso_codes);
            $description[$value->iso_codes] = ($request->input('description_'.$value->iso_codes) == null) ?
                $request->input('description_'.config('custom.language.default')) : $request->input('description_'.$value->iso_codes);
        }

        $playlist->slug = Str::limit(Str::slug($request->slug, '-'), 50);
        $playlist->name = $name;
        $playlist->description = $description;
        $playlist->publish = (bool)$request->publish;
        $playlist->video_limit = $request->video_limit ?? null;
        $playlist->is_detail = (bool)$request->is_detail;
        $playlist->custom_view_id = $request->custom_view_id ?? null;
        $playlist->banner = [
            'file_path' => str_replace(url('storage/'), '', $request->banner_file) ?? null,
            'title' => $request->banner_title ?? null,
            'alt' => $request->banner_alt ?? null,
        ];
        $playlist->field_category_id = $request->field_category_id ?? null;
        if (!empty($request->field_category_id)) {

            $field = $this->field->find($request->field_category_id);
            foreach ($field->fields as $key => $value) {
                $custom_field[$key] = [
                    $value->name => $request->input('field_'.$value->name) ?? null
                ];
            }

            $playlist->custom_field = $custom_field;

        } else {
            $playlist->custom_field = null;
        }

        return $playlist;
    }

    public function publish(int $id)
    {
        $playlist = $this->find($id);
        $playlist->publish = !$playlist->publish;
        $playlist->updated_by = Auth::user()->id;
        $playlist->save();

        return $playlist;
    }

    public function position(int $id, int $position)
    {
        if ($position >= 1) {

            $playlist = $this->find($id);
            $this->model->where('position', $position)->update([
                'position' => $playlist->position,
            ]);
            $playlist->position = $position;
            $playlist->updated_by = Auth::user()->id;
            $playlist->save();

            return $playlist;
        }
    }

    public function sort(int $id, $position)
    {
        $find = $this->find($id);

        $playlist = $this->model->where('id', $id)->update([
            'position' => $position
        ]);

        return $playlist;
    }

    public function recordViewer(int $id)
    {
        $playlist = $this->find($id);
        $playlist->viewer = ($playlist->viewer+1);
        $playlist->save();

        return $playlist;
    }

    public function delete(int $id)
    {
        $playlist = $this->find($id);

        if ($playlist->videos->count() == 0 && $playlist->menu()->count() == 0) {
            Storage::deleteDirectory(config('custom.gallery.video.path').$id);
            $playlist->delete();

            return true;

        } else {
            return false;
        }
    }
}