<?php

namespace App\Models\Catalog\Product;

use App\Models\User;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CatalogProductMedia extends Model
{
    use HasFactory;

    protected $table = 'catalog_product_medias';
    protected $guarded = [];

    protected $casts = [
        'caption' => 'json',
    ];

    public static function boot()
    {
        parent::boot();

        CatalogProductMedia::observe(LogObserver::class);
    }

    public function product()
    {
        return $this->belongsTo(CatalogProduct::class, 'catalog_product_id');
    }

    public function createBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updateBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleteBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function fileSrc()
    {
        if ($this->is_video == 0 && $this->is_youtube == 0) {

            $type = [
                'image' => Storage::url(config('custom.files.product.path').
                    $this->catalog_product_id.'/'.$this->file),
                'name' => 'IMAGE'
            ];

        } elseif ($this->is_video == 1 && $this->is_youtube == 0) {

            if (!empty($this->thumbnail)) {
                $src = Storage::url(config('custom.files.product.thumbnail.path').
                    $this->catalog_product_id.'/'.$this->thumbnail);
            } else {
                $src = asset(config('custom.files.cover_playlist.file'));
            }

            $type = [
                'image' => $src,
                'video' => Storage::url(config('custom.files.product.path').
                    $this->catalog_product_id.'/'.$this->file),
                'name' => 'VIDEO'
            ];

        } elseif ($this->is_video == 1 && $this->is_youtube == 1) {            

            $type = [
                'image' => 'https://i.ytimg.com/vi/'.$this->youtube_id.'/mqdefault.jpg',
                'video' => 'https://www.youtube.com/embed/'.$this->youtube_id.'?rel=0;showinfo=0',
                'name' => 'YOUTUBE VIDEO'
            ];
        }

        return $type;
    }
}
