<?php

namespace App\Services\Catalog\Product;

use App\Models\Catalog\Product\CatalogProductMedia;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CatalogProductMediaService
{
    private $model;

    public function __construct(
        CatalogProductMedia $model
    )
    {
        $this->model = $model;
    }

    public function getMediaList($request, int $productId)
    {
        $query = $this->model->query();

        $query->where('catalog_product_id', $productId);
        $query->when($request->q, function ($query, $q) {
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

    public function store($request, int $productId)
    {
        $media = new CatalogProductMedia;
        $media->catalog_product_id = $productId;
        $media->is_video = (bool)$request->is_video;
        $media->is_youtube = (bool)$request->is_youtube;
        
        if ((bool)$request->is_video == 1 && (bool)$request->is_youtube == 1) {
            $media->youtube_id = $request->youtube_id ?? null;
        } else {

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = Str::random(3).'-'.str_replace(' ', '-', $file->getClientOriginalName());
    
                Storage::put(config('custom.files.product.path').$productId.'/'.$fileName, 
                    file_get_contents($file));
            }

            if ((bool)$request->is_video == 1) {
                if ($request->hasFile('thumbnail')) {
                    $fileThumb = $request->file('thumbnail');
                    $fileNameThumb = Str::random(3).'-'.str_replace(' ', '-', 
                        $fileThumb->getClientOriginalName());
        
                    Storage::put(config('custom.files.product.thumbnail.path').$productId.'/'.$fileNameThumb, 
                        file_get_contents($fileThumb));
                }
            }

            $media->file = $fileName ?? null;
            $media->thumbnail = $fileNameThumb ?? null;
        }

        $media->caption = [
            'title' => $request->title ?? null,
            'description' => $request->description ?? null,
            'alt' => $request->alt ?? null,
        ];

        $media->position = $this->model->where('catalog_product_id', $productId)
            ->max('position') + 1;
        $media->created_by = Auth::user()->id;
        $media->save();

        return $media;
    }

    public function storeMultiple($request, int $productId)
    {
        $media = new CatalogProductMedia;
        $media->catalog_product_id = $productId;
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = Str::random(3).'-'.str_replace(' ', '-', $file->getClientOriginalName());
            $extesion = $file->getClientOriginalExtension();

            Storage::put(config('custom.files.product.path').$productId.'/'.$fileName, 
                file_get_contents($file));

            $media->is_video = ($extesion == 'mp4' || $extesion == 'webm') ? 1 : 0;
            $media->is_youtube = 0;
        }

        $media->file = $fileName ?? null;

        $media->caption = [
            'title' => null,
            'description' => null,
            'alt' => null,
        ];
        $media->position = $this->model->where('catalog_product_id', $productId)
            ->max('position') + 1;
        $media->created_by = Auth::user()->id;
        $media->save();

        return $media;
    }

    public function update($request, int $id)
    {
        $media = $this->find($id);

        if ($media->is_youtube == 0) {
            
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = Str::random(3).'-'.str_replace(' ', '-', $file->getClientOriginalName());

                Storage::delete(config('custom.files.product.path').$media->catalog_product_id.
                '/'.$request->old_file);
    
                Storage::put(config('custom.files.product.path').$media->catalog_product_id.'/'.$fileName, 
                    file_get_contents($file));

                $media->file = $fileName ?? $media->file;
            }

            if ($media->is_video == 1) {
                if ($request->hasFile('thumbnail')) {
                    $fileThumb = $request->file('thumbnail');
                    $fileNameThumb = Str::random(3).'-'.str_replace(' ', '-', $fileThumb->getClientOriginalName());

                    Storage::delete(config('custom.files.product.thumbnail.path').$media->catalog_product_id.
                    '/'.$request->old_thumbnail);
        
                    Storage::put(config('custom.files.product.thumbnail.path').$media->catalog_product_id.'/'.$fileNameThumb, 
                        file_get_contents($fileThumb));

                    $media->thumbnail = $fileNameThumb ?? $media->thumbnail;
                }
            }

        } else {
            
            $media->youtube_id = $request->youtube_id ?? $media->youtube_id;

        }

        $media->caption = [
            'title' => $request->title ?? null,
            'description' => $request->description ?? null,
            'alt' => $request->alt ?? null,
        ];

        $media->updated_by = Auth::user()->id;
        $media->save();

        return $media;
    }

    public function position(int $id, int $position)
    {
        if ($position >= 1) {

            $media = $this->find($id);
            $this->model->where('position', $position)->update([
                'position' => $media->position,
            ]);
            $media->position = $position;
            $media->updated_by = Auth::user()->id;
            $media->save();

            return $media;
        }
    }

    public function sort(int $id, $position)
    {
        $find = $this->find($id);

        $media = $this->model->where('id', $id)
                ->where('catalog_product_id', $find->catalog_product_id)->update([
            'position' => $position
        ]);

        return $media;
    }

    public function delete(int $id)
    {
        $media = $this->find($id);
        if (empty($media->youtube_id)) {
            Storage::delete(config('custom.files.product.path').$media->catalog_product_id.
                '/'.$media->file);

            if ($media->is_video == 1) {
                Storage::delete(config('custom.files.product.thumbnail.path').$media->catalog_product_id.
                '/'.$media->thumbnail);
            }
        }
        $media->delete();

        return $media;
    }
}