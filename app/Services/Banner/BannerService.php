<?php

namespace App\Services\Banner;

use App\Models\Banner\Banner;
use App\Services\LanguageService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerService
{
    private $model, $lang;

    public function __construct(
        Banner $model,
        LanguageService $lang
    )
    {
        $this->model = $model;
        $this->lang = $lang;
    }

    public function getBannerList($request, int $categoryId)
    {
        $query = $this->model->query();

        $query->where('banner_category_id', $categoryId);
        $query->when($request, function ($query, $req) {
            if ($req->s != '') {
                $query->where('publish', $req->s);
            }
        })->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('file', 'like', '%'.$q.'%')
                    ->orWhere('youtube_id', 'like', '%'.$q.'%')
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

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function store($request, int $categoryId)
    {
        $banner = new Banner;
        $banner->banner_category_id = $categoryId;
        $banner->is_video = (bool)$request->is_video;
        $banner->is_youtube = (bool)$request->is_youtube;
        
        if ((bool)$request->is_video == 1 && (bool)$request->is_youtube == 1) {
            $banner->youtube_id = $request->youtube_id ?? null;
        } else {

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = Str::random(3).'-'.str_replace(' ', '-', $file->getClientOriginalName());
    
                Storage::put(config('custom.files.banner.path').$categoryId.'/'.$fileName, 
                    file_get_contents($file));
            }

            if ((bool)$request->is_video == 1) {
                if ($request->hasFile('thumbnail')) {
                    $fileThumb = $request->file('thumbnail');
                    $fileNameThumb = Str::random(3).'-'.str_replace(' ', '-', 
                        $fileThumb->getClientOriginalName());
        
                    Storage::put(config('custom.files.banner.thumbnail.path').$categoryId.'/'.$fileNameThumb, 
                        file_get_contents($fileThumb));
                }
            }

            $banner->file = $fileName ?? null;
            $banner->thumbnail = $fileNameThumb ?? null;
        }

        $this->setField($request, $banner);
        $banner->position = $this->model->where('banner_category_id', $categoryId)
            ->max('position') + 1;
        $banner->created_by = Auth::user()->id;
        $banner->save();

        return $banner;
    }

    public function storeMultiple($request, int $categoryId)
    {
        $banner = new Banner;
        $banner->banner_category_id = $categoryId;
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = Str::random(3).'-'.str_replace(' ', '-', $file->getClientOriginalName());
            $extesion = $file->getClientOriginalExtension();

            Storage::put(config('custom.files.banner.path').$categoryId.'/'.$fileName, 
                file_get_contents($file));

            $banner->is_video = ($extesion == 'mp4' || $extesion == 'webm') ? 1 : 0;
            $banner->is_youtube = 0;
        }

        $banner->file = $fileName ?? null;
        $banner->publish = 1;

        $this->setField($request, $banner);
        $banner->position = $this->model->where('banner_category_id', $categoryId)
            ->max('position') + 1;
        $banner->created_by = Auth::user()->id;
        $banner->save();

        return $banner;
    }

    public function update($request, int $id)
    {
        $banner = $this->find($id);

        if ($banner->is_youtube == 0) {
            
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = Str::random(3).'-'.str_replace(' ', '-', $file->getClientOriginalName());

                Storage::delete(config('custom.files.banner.path').$banner->banner_category_id.
                '/'.$request->old_file);
    
                Storage::put(config('custom.files.banner.path').$banner->banner_category_id.'/'.$fileName, 
                    file_get_contents($file));

                $banner->file = $fileName ?? $banner->file;
            }

            if ($banner->is_video == 1) {
                if ($request->hasFile('thumbnail')) {
                    $fileThumb = $request->file('thumbnail');
                    $fileNameThumb = Str::random(3).'-'.str_replace(' ', '-', $fileThumb->getClientOriginalName());

                    Storage::delete(config('custom.files.banner.thumbnail.path').$banner->banner_category_id.
                    '/'.$request->old_thumbnail);
        
                    Storage::put(config('custom.files.banner.thumbnail.path').$banner->banner_category_id.'/'.$fileNameThumb, 
                        file_get_contents($fileThumb));

                    $banner->thumbnail = $fileNameThumb ?? $banner->thumbnail;
                }
            }

        } else {
            
            $banner->youtube_id = $request->youtube_id ?? $banner->youtube_id;

        }

        $this->setField($request, $banner);
        $banner->updated_by = Auth::user()->id;
        $banner->save();

        return $banner;
    }

    public function setField($request, $banner)
    {
        foreach ($this->lang->getLang(false, true) as $key => $value) {
            $title[$value->iso_codes] = ($request->input('title_'.$value->iso_codes) == null) ?
                $request->input('title_'.config('custom.language.default')) : $request->input('title_'.$value->iso_codes);
            $description[$value->iso_codes] = ($request->input('description_'.$value->iso_codes) == null) ?
                $request->input('description_'.config('custom.language.default')) : $request->input('description_'.$value->iso_codes);
        }
        
        $banner->title = $title;
        $banner->description = $description;
        $banner->alt = $request->alt ?? null;
        $banner->url = $request->url ?? null;
        $banner->publish = (bool)$request->publish;

        return $banner;
    }

    public function publish(int $id)
    {
        $banner = $this->find($id);
        $banner->publish = !$banner->publish;
        $banner->updated_by = Auth::user()->id;
        $banner->save();

        return $banner;
    }

    public function position(int $id, int $position)
    {
        if ($position >= 1) {

            $banner = $this->find($id);
            $this->model->where('position', $position)->update([
                'position' => $banner->position,
            ]);
            $banner->position = $position;
            $banner->updated_by = Auth::user()->id;
            $banner->save();

            return $banner;
        }
    }

    public function sort(int $id, $position)
    {
        $find = $this->find($id);

        $banner = $this->model->where('id', $id)
                ->where('banner_category_id', $find->banner_category_id)->update([
            'position' => $position
        ]);

        return $banner;
    }

    public function delete(int $id)
    {
        $banner = $this->find($id);
        if (empty($banner->youtube_id)) {
            Storage::delete(config('custom.files.banner.path').$banner->banner_category_id.
                '/'.$banner->file);

            if ($banner->is_video == 1) {
                Storage::delete(config('custom.files.banner.thumbnail.path').$banner->banner_category_id.
                '/'.$banner->thumbnail);
            }
        }
        $banner->delete();

        return $banner;
    }
}