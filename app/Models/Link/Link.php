<?php

namespace App\Models\Link;

use App\Models\Configuration;
use App\Models\IndexUrl;
use App\Models\Master\Field\FieldCategory;
use App\Models\Master\Template;
use App\Models\Menu\Menu;
use App\Models\User;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class Link extends Model
{
    use HasFactory;

    protected $table = 'links';
    protected $guarded = [];

    protected $casts = [
        'name' => 'json',
        'description' => 'json',
        'cover' => 'json',
        'banner' => 'json',
        'meta_data' => 'json',
        'custom_field' => 'json'
    ];

    public static function boot()
    {
        parent::boot();

        Link::observe(LogObserver::class);
    }

    public function indexing()
    {
        return $this->morphOne(IndexUrl::class, 'urlable');
    }

    public function medias()
    {
        return $this->hasMany(LinkMedia::class, 'link_id');
    }

    public function field()
    {
        return $this->belongsTo(FieldCategory::class, 'field_category_id');
    }

    public function customView()
    {
        return $this->belongsTo(Template::class, 'custom_view_id');
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

    public function fieldLang($field, $lang = null)
    {
        if ($lang == null) {
            $lang = App::getLocale();
        }

        return $this->hasMany(Link::class, 'id')->first()[$field][$lang];
    }
    
    public function scopePublish($query)
    {
        return $query->where('publish', 1);
    }

    public function coverSrc()
    {
        if (!empty($this->cover['file_path'])) {
            $cover = Storage::url($this->cover['file_path']);
        } else {
            $cover = asset(config('custom.files.cover.file'));
        }

        return $cover;
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
