<?php

namespace App\Models\Link;

use App\Models\Configuration;
use App\Models\Master\Field\FieldCategory;
use App\Models\User;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class LinkMedia extends Model
{
    use HasFactory;

    protected $table = 'link_medias';
    protected $guarded = [];

    protected $casts = [
        'title' => 'json',
        'description' => 'json',
        'cover' => 'json',
        'banner' => 'json',
        'custom_field' => 'json'
    ];

    public static function boot()
    {
        parent::boot();

        LinkMedia::observe(LogObserver::class);
    }

    public function link()
    {
        return $this->belongsTo(Link::class, 'link_id');
    }

    public function field()
    {
        return $this->belongsTo(FieldCategory::class, 'field_category_id');
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

        return $this->hasMany(LinkMedia::class, 'id')->first()[$field][$lang];
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
}
