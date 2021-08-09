<?php

namespace App\Models\Gallery;

use App\Models\Configuration;
use App\Models\Master\Field\FieldCategory;
use App\Models\Master\Template;
use App\Models\Menu\Menu;
use App\Models\User;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class Album extends Model
{
    use HasFactory;

    protected $table = 'gallery_albums';
    protected $guarded = [];

    protected $casts = [
        'name' => 'json',
        'description' => 'json',
        'banner' => 'json',
        'custom_field' => 'json'
    ];

    public static function boot()
    {
        parent::boot();

        Album::observe(LogObserver::class);
    }

    public function photos()
    {
        return $this->hasMany(AlbumPhoto::class, 'album_id');
    }
    
    public function customView()
    {
        return $this->belongsTo(Template::class, 'custom_view_id');
    }

    public function field()
    {
        return $this->belongsTo(FieldCategory::class, 'field_category_id');
    }

    public function menu()
    {
        return $this->morphMany(Menu::class, 'menuable');
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
        return $this->belongsTo(User::class, 'delete_by');
    }

    public function photoCover($id)
    {
        $photo = AlbumPhoto::where('album_id', $id)->first();

        if (!empty($photo)) {

            $cover = Storage::url(config('custom.files.gallery.photo.path').'/'.$id.'/'.
                $photo->file);

        } else {

            $cover = asset(config('custom.files.cover_album.file'));

        }

        return $cover;
    }

    public function fieldLang($field, $lang = null)
    {
        if ($lang == null) {
            $lang = App::getLocale();
        }

        return $this->hasMany(Album::class, 'id')->first()[$field][$lang];
    }

    public function scopePublish($query)
    {
        return $query->where('publish', 1);
    }

    public function bannerSrc()
    {
        if (!empty($this->banner['file_path'])) {
            $banner = Storage::url($this->banner['file_path']);
        } else {
            if (!empty(Configuration::value('banner_default'))) {
                $banner = Storage::url(config('custom.files.config.path').
                    Configuration::value('banner_default'));
            } else {
                $banner = asset(config('custom.files.config.banner_default.file'));
            }
        }

        return $banner;
    }

    public function customConfig()
    {
        $config = [
            'publish' => config('custom.label.publish.'.$this->publish),
        ];

        return $config;
    }
}
