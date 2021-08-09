<?php

namespace App\Models\Banner;

use App\Models\User;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    use HasFactory;

    protected $table = 'banners';
    protected $guarded = [];

    protected $casts = [
        'title' => 'json',
        'description' => 'json',
    ];

    public static function boot()
    {
        parent::boot();

        Banner::observe(LogObserver::class);
    }

    public function category()
    {
        return $this->belongsTo(BannerCategory::class, 'banner_category_id');
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

    public function fieldLang($field, $lang = null)
    {
        if ($lang == null) {
            $lang = App::getLocale();
        }

        return $this->hasMany(Banner::class, 'id')->first()[$field][$lang];
    }

    public function scopeVideo($query)
    {
        return $query->where('is_video', 1);
    }

    public function scopeYoutube($query)
    {
        return $query->where('is_youtube', 1);
    }

    public function scopePublish($query)
    {
        return $query->where('publish', 1);
    }

    public function fileSrc()
    {
        if ($this->is_video == 0 && $this->is_youtube == 0) {

            $type = [
                'image' => Storage::url(config('custom.files.banner.path').
                    $this->banner_category_id.'/'.$this->file),
                'name' => 'IMAGE'
            ];

        } elseif ($this->is_video == 1 && $this->is_youtube == 0) {

            if (!empty($this->thumbnail)) {
                $src = Storage::url(config('custom.files.banner.thumbnail.path').
                    $this->banner_category_id.'/'.$this->thumbnail);
            } else {
                $src = asset(config('custom.files.cover_playlist.file'));
            }

            $type = [
                'image' => $src,
                'video' => Storage::url(config('custom.files.banner.path').
                    $this->banner_category_id.'/'.$this->file),
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

    public function customConfig()
    {
        $config = [
            'publish' => config('custom.label.publish.'.$this->publish),
        ];

        return $config;
    }
}
