<?php

namespace App\Services\Gallery;

use App\Models\Gallery\Album;
use App\Services\LanguageService;
use App\Services\Master\Field\FieldCategoryService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AlbumService
{
    private $model, $lang, $field;

    public function __construct(
        Album $model,
        LanguageService $lang,
        FieldCategoryService $field
    )
    {
        $this->model = $model;
        $this->lang = $lang;
        $this->field = $field;
    }

    public function getAlbumList($request)
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

    public function getAlbum($request = null, $withPaginate = null, $limit = null, $categoryId = null)
    {
        $query = $this->model->query();

        $query->publish();

        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

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
        $album = new Album;
        $this->setField($request, $album);
        $album->position = $this->model->max('position') + 1;
        $album->created_by = Auth::user()->id;
        $album->save();

        return $album;
    }

    public function update($request, int $id)
    {
        $album = $this->find($id);
        $this->setField($request, $album);
        $album->updated_by = Auth::user()->id;
        $album->save();

        return $album;
    }

    public function setField($request, $album)
    {
        foreach ($this->lang->getLang(false, true) as $key => $value) {
            $name[$value->iso_codes] = ($request->input('name_'.$value->iso_codes) == null) ?
                $request->input('name_'.config('custom.language.default')) : $request->input('name_'.$value->iso_codes);
            $description[$value->iso_codes] = ($request->input('description_'.$value->iso_codes) == null) ?
                $request->input('description_'.config('custom.language.default')) : $request->input('description_'.$value->iso_codes);
        }

        $album->category_id = $request->category_id;
        $album->slug = Str::limit(Str::slug($request->slug, '-'), 50);
        $album->name = $name;
        $album->description = $description;
        $album->publish = (bool)$request->publish;
        $album->photo_limit = $request->photo_limit ?? null;
        $album->is_detail = (bool)$request->is_detail;
        $album->custom_view_id = $request->custom_view_id ?? null;
        $album->banner = [
            'file_path' => Str::replace(url('storage/'), '', $request->banner_file) ?? null,
            'title' => $request->banner_title ?? null,
            'alt' => $request->banner_alt ?? null,
        ];
        $album->field_category_id = $request->field_category_id ?? null;
        if (!empty($request->field_category_id)) {

            $field = $this->field->find($request->field_category_id);
            foreach ($field->fields as $key => $value) {
                $custom_field[$key] = [
                    $value->name => $request->input('field_'.$value->name) ?? null
                ];
            }

            $album->custom_field = $custom_field;

        } else {
            $album->custom_field = null;
        }

        return $album;
    }

    public function publish(int $id)
    {
        $album = $this->find($id);
        $album->publish = !$album->publish;
        $album->updated_by = Auth::user()->id;
        $album->save();

        return $album;
    }

    public function position(int $id, int $position)
    {
        if ($position >= 1) {

            $album = $this->find($id);
            $this->model->where('position', $position)->update([
                'position' => $album->position,
            ]);
            $album->position = $position;
            $album->updated_by = Auth::user()->id;
            $album->save();

            return $album;
        }
    }

    public function sort(int $id, $position)
    {
        $find = $this->find($id);

        $album = $this->model->where('id', $id)->update([
            'position' => $position
        ]);

        return $album;
    }

    public function recordViewer(int $id)
    {
        $album = $this->find($id);
        $album->viewer = ($album->viewer+1);
        $album->save();

        return $album;
    }

    public function delete(int $id)
    {
        $album = $this->find($id);

        if ($album->photos->count() == 0 && $album->menu()->count() == 0) {
            Storage::deleteDirectory(config('custom.gallery.photo.path').$id);
            $album->delete();

            return true;

        } else {
            return false;
        }
    }
}