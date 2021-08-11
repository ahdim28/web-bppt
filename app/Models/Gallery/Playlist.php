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

class Playlist extends Model
{
    use HasFactory;

    protected $table = 'gallery_playlists';
    protected $guarded = [];

    protected $casts = [
        'name' => 'json',
        'description' => 'json',
        'banner' => 'json',
        'custom_field' => 'json',
    ];

    public static function boot()
    {
        parent::boot();

        Playlist::observe(LogObserver::class);
    }

    public function category()
    {
        return $this->belongsTo(PlaylistCategory::class, 'category_id');
    }

    public function videos()
    {
        return $this->hasMany(PlaylistVideo::class, 'playlist_id');
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
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function coverSrc($id)
    {
        $video = PlaylistVideo::where('playlist_id', $id)->first();

        if (!empty($video)) {

            if (!empty($video->file)) {

                $cover = Storage::url(config('custom.files.gallery.video.path').'/'.$id.'/thumbnail/'.
                    $video->file);

            } elseif (!empty($video->youtube_id)) {

                $cover = 'https://i.ytimg.com/vi/'.$video->youtube_id.'/mqdefault.jpg';

            } else {

                $cover = asset(config('custom.files.cover_playlist.file'));

            }

        } else {
            $cover = asset(config('custom.files.cover_playlist.file'));
        }

        return $cover;
    }

    public function fieldLang($field, $lang = null)
    {
        if ($lang == null) {
            $lang = App::getLocale();
        }

        return $this->hasMany(Playlist::class, 'id')->first()[$field][$lang];
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
