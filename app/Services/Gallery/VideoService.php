<?php

namespace App\Services\Gallery;

use App\Models\Gallery\PlaylistVideo;
use App\Services\LanguageService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoService
{
    private $model, $lang;

    public function __construct(
        PlaylistVideo $model,
        LanguageService $lang
    )
    {
        $this->model = $model;
        $this->lang = $lang;
    }

    public function getVideoList($request, $playlistId)
    {
        $query = $this->model->query();

        $query->where('playlist_id', $playlistId);
        $query->when($request, function ($query, $req) {
            if ($req->s != '') {
                $query->where('publish', $req->s);
            }
            if ($req->is_youtube != '') {
                $query->where('is_youtube', $req->is_youtube);
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

    public function getVideo($request = null, $withPaginate = null, $limit = null, $categoryId = null, $playlistId = null)
    {
        $query = $this->model->query();

        $query->publish();
        if (!empty($categoryId)) {
            $query->whereHas('playlist', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            });
        }

        if (!empty($playlistId)) {
            $query->where('playlist_id', $playlistId);
        }

        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('file', 'like', '%'.$q.'%')
                    ->orWhere('title->'.App::getLocale(), 'like', '%'.$q.'%')
                    ->orWhere('description->'.App::getLocale(), 'like', '%'.$q.'%');
            });
        });

        $query->orderBy('created_at', 'DESC');
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

    public function store($request, int $playlistId)
    {
        $video = new PlaylistVideo;
        $video->playlist_id = $playlistId;
        $video->is_youtube = (bool)$request->is_youtube;

        if ((bool)$request->is_youtube == 0) {

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = $file->getClientOriginalName();
                if (file_exists(storage_path('app/public/gallery/video/'.$playlistId.'/'.$fileName))) {
                    $fileName = Str::random(3).'-'.$file->getClientOriginalName();
                }
    
                Storage::put(config('custom.files.gallery.video.path').$playlistId.'/'.
                    $fileName, file_get_contents($file));
            }
    
            if ($request->hasFile('thumbnail')) {
                $fileThumb = $request->file('thumbnail');
                $fileNameThumb = $file->getClientOriginalName();
                if (file_exists(storage_path('app/public/gallery/video/thumbnail/'.$playlistId.'/'.$fileName))) {
                    $fileNameThumb = Str::random(3).'-'.$fileThumb->getClientOriginalName();
                }
    
                Storage::put(config('custom.files.gallery.video.thumbnail.path').$playlistId.'/'.
                    $fileNameThumb, file_get_contents($fileThumb));
            }

            $video->file = $fileName ?? null;
            $video->thumbnail = $fileNameThumb ?? null;

        } else {

            $video->youtube_id = $request->youtube_id;
        }
        
        $this->setField($request, $video);
        $video->position = $this->model->where('playlist_id', $playlistId)->max('position') + 1;
        $video->created_by = Auth::user()->id;
        $video->save();

        return $video;
    }

    public function update($request, int $id)
    {
        $video = $this->find($id);

        if ($video->is_youtube == 0) {
            
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = $file->getClientOriginalName();
                if (file_exists(storage_path('app/public/gallery/video/'.$video->playlist_id.'/'.$fileName))) {
                    $fileName = Str::random(3).'-'.$file->getClientOriginalName();
                }
    
                Storage::delete(config('custom.files.gallery.video.path').$video->playlist_id.'/'.
                '/'.$request->old_file);

                Storage::put(config('custom.files.gallery.video.path').$video->playlist_id.'/'.
                    $fileName, file_get_contents($file));
            }
    
            if ($request->hasFile('thumbnail')) {
                $fileThumb = $request->file('thumbnail');
                $fileNameThumb = $file->getClientOriginalName();
                if (file_exists(storage_path('app/public/gallery/video/thumbnail/'.$video->playlist_id.'/'.$fileName))) {
                    $fileNameThumb = Str::random(3).'-'.$fileThumb->getClientOriginalName();
                }
    
                Storage::delete(config('custom.files.gallery.video.thumbnail.path').$video->playlist_id.'/'.
                    '/'.$request->old_thumbnail);

                Storage::put(config('custom.files.gallery.video.thumbnail.path').$video->playlist_id.'/'.
                    $fileNameThumb, file_get_contents($fileThumb));
            }

            $video->file = $fileName ?? $video->file;
            $video->thumbnail = $fileNameThumb ?? $video->thumbnail;

        } else {
            $video->youtube_id = $request->youtube_id;
        }
        
        $this->setField($request, $video);
        $video->updated_by = Auth::user()->id;
        $video->save();

        return $video;
    }

    public function setField($request, $video)
    {
        foreach ($this->lang->getLang(false, true) as $key => $value) {
            $title[$value->iso_codes] = ($request->input('title_'.$value->iso_codes) == null) ?
                $request->input('title_'.config('custom.language.default')) : $request->input('title_'.$value->iso_codes);
            $description[$value->iso_codes] = ($request->input('description_'.$value->iso_codes) == null) ?
                $request->input('description_'.config('custom.language.default')) : $request->input('description_'.$value->iso_codes);
        }

        $video->title = $title;
        $video->description = $description;
        $video->publish = (bool)$request->publish;

        return $video;
    }

    public function publish(int $id)
    {
        $video = $this->find($id);
        $video->publish = !$video->publish;
        $video->updated_by = Auth::user()->id;
        $video->save();

        return $video;
    }

    public function position(int $id, int $position)
    {
        if ($position >= 1) {

            $video = $this->find($id);
            $this->model->where('position', $position)->update([
                'position' => $video->position,
            ]);
            $video->position = $position;
            $video->updated_by = Auth::user()->id;
            $video->save();

            return $video;
        }
    }

    public function sort(int $id, $position)
    {
        $find = $this->find($id);

        $video = $this->model->where('id', $id)
                ->where('playlist_id', $find->playlist_id)->update([
            'position' => $position
        ]);

        return $video;
    }

    public function delete(int $id)
    {
        $video = $this->find($id);
        Storage::delete(config('custom.files.gallery.video.path').$video->playlist_id.'/'.
            $video->file);
        if (!empty($video->thumbnail)) {
            Storage::delete(config('custom.files.gallery.video.thumbnail.path').$video->playlist_id.'/'.
            $video->thumbnail);
        }
        $video->delete();

        return $video;
    }
}