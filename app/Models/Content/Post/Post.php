<?php

namespace App\Models\Content\Post;

use App\Models\Configuration;
use App\Models\Content\Category;
use App\Models\Content\Section;
use App\Models\Master\Field\FieldCategory;
use App\Models\Master\Media;
use App\Models\Master\Tags\TagType;
use App\Models\Master\Template;
use App\Models\Menu\Menu;
use App\Models\User;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $table = 'content_posts';
    protected $guarded = [];

    protected $casts = [
        'title' => 'json',
        'intro' => 'json',
        'content' => 'json',
        'cover' => 'json',
        'banner' => 'json',
        'meta_data' => 'json',
        'custom_field' => 'json'
    ];

    public static function boot()
    {
        parent::boot();

        Post::observe(LogObserver::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function files()
    {
        return $this->hasMany(PostFile::class, 'post_id');
    }

    public function profile()
    {
        return $this->hasOne(PostProfile::class, 'post_id');
    }

    public function event()
    {
        return $this->hasOne(PostEvent::class, 'post_id');
    }

    public function field()
    {
        return $this->belongsTo(FieldCategory::class, 'field_category_id');
    }

    public function customView()
    {
        return $this->belongsTo(Template::class, 'custom_view_id');
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function tags()
    {
        return $this->morphMany(TagType::class, 'tagable');
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

        return $this->hasMany(Post::class, 'id')->first()[$field][$lang];
    }

    public function scopePublish($query)
    {
        return $query->where('publish', 1);
    }

    public function scopePublic($query)
    {
        return $query->where('public', 1);
    }

    public function scopeSelection($query)
    {
        return $query->where('selection', 1);
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
            'public' => config('custom.label.optional.'.$this->public),
        ];

        return $config;
    }
}
