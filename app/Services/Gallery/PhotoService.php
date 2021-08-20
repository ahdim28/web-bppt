<?php

namespace App\Services\Gallery;

use App\Models\Gallery\AlbumPhoto;
use App\Services\LanguageService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PhotoService
{
    private $model, $lang;

    public function __construct(
        AlbumPhoto $model,
        LanguageService $lang
    )
    {
        $this->model = $model;
        $this->lang = $lang;
    }

    public function getPhotoList($request, $albumId)
    {
        $query = $this->model->query();

        $query->where('album_id', $albumId);
        $query->when($request, function ($query, $req) {
            if ($req->s != '') {
                $query->where('publish', $req->s);
            }
        })->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('file', 'like', '%'.$q.'%')
                    ->orWhere('title->'.App::getLocale(), 'like', '%'.$q.'%')
                    ->orWhere('description->'.App::getLocale(), 'like', '%'.$q.'%');
            });
        });

        $limit = 6;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->orderBy('position', 'ASC')->paginate($limit);

        return $result;
    }

    public function getPhoto($request = null, $withPaginate = false, $limit = null, $categoryId = null, $albumId = null)
    {
        $query = $this->model->query();

        $query->publish();
        if (!empty($categoryId)) {
            $query->whereHas('album', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            });
        }

        if (!empty($albumId)) {
            $query->where('album_id', $albumId);
        }

        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('file', 'like', '%'.$q.'%')
                    ->orWhere('title->'.App::getLocale(), 'like', '%'.$q.'%')
                    ->orWhere('description->'.App::getLocale(), 'like', '%'.$q.'%');
            });
        });

        $query->orderBy('position', 'ASC');
        if ($withPaginate == true) {
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

    public function store($request, int $albumId)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            if (file_exists(storage_path('app/public/gallery/photo/'.$albumId.'/'.$fileName))) {
                $fileName = Str::random(3).'-'.$file->getClientOriginalName();
            }

            Storage::put(config('custom.files.gallery.photo.path').$albumId.'/'.
                $fileName, file_get_contents($file));

            $photo = new AlbumPhoto;
            $photo->album_id = $albumId;
            $photo->file = $fileName;
            $photo->file_type = $file->getClientOriginalExtension();
            $photo->file_size = $file->getSize();
            $this->setField($request, $photo);
            $photo->position = $this->model->where('album_id', $albumId)->max('position') + 1;
            $photo->created_by = Auth::user()->id;
            $photo->save();

            return $photo;

        } else {

            return false;
        }
    }

    public function update($request, int $id)
    {
        $photo = $this->find($id);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            if (file_exists(storage_path('app/public/gallery/photo/'.$photo->album_id.'/'.$fileName))) {
                $fileName = Str::random(3).'-'.$file->getClientOriginalName();
            }

            Storage::delete(config('custom.files.gallery.photo.path').$photo->album_id.
                '/'.$request->old_file);

            Storage::put(config('custom.files.gallery.photo.path').$photo->album_id.'/'.
                $fileName, file_get_contents($file));

            $photo->file = $fileName;
            $photo->file_type = $file->getClientOriginalExtension();
            $photo->file_size = $file->getSize();
        }

        $this->setField($request, $photo);
        $photo->updated_by = Auth::user()->id;
        $photo->save();

        return $photo;
    }

    public function setField($request, $photo)
    {
        foreach ($this->lang->getLang(false, true) as $key => $value) {
            $title[$value->iso_codes] = ($request->input('title_'.$value->iso_codes) == null) ?
                $request->input('title_'.config('custom.language.default')) : $request->input('title_'.$value->iso_codes);
            $description[$value->iso_codes] = ($request->input('description_'.$value->iso_codes) == null) ?
                $request->input('description_'.config('custom.language.default')) : $request->input('description_'.$value->iso_codes);
        }

        $photo->title = $title;
        $photo->description = $description;
        $photo->alt = $request->alt ?? null;
        $photo->publish = (bool)$request->publish;

        return $photo;
    }

    public function publish(int $id)
    {
        $photo = $this->find($id);
        $photo->publish = !$photo->publish;
        $photo->updated_by = Auth::user()->id;
        $photo->save();

        return $photo;
    }

    public function position(int $id, int $position)
    {
        if ($position >= 1) {

            $photo = $this->find($id);
            $this->model->where('position', $position)->update([
                'position' => $photo->position,
            ]);
            $photo->position = $position;
            $photo->updated_by = Auth::user()->id;
            $photo->save();

            return $photo;
        }
    }

    public function sort(int $id, $position)
    {
        $find = $this->find($id);

        $photo = $this->model->where('id', $id)
                ->where('album_id', $find->album_id)->update([
            'position' => $position
        ]);

        return $photo;
    }

    public function delete(int $id)
    {
        $photo = $this->find($id);
        Storage::delete(config('custom.files.gallery.photo.path').$photo->album_id.'/'.
            $photo->file);
        $photo->delete();

        return $photo;
    }
}