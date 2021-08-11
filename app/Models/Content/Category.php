<?php

namespace App\Models\Content;

use App\Models\Configuration;
use App\Models\Content\Post\Post;
use App\Models\Master\Field\FieldCategory;
use App\Models\Master\Template;
use App\Models\Menu\Menu;
use App\Models\User;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;

    protected $table = 'content_categories';
    protected $guarded = [];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'banner' => 'array',
        'custom_field' => 'array'
    ];

    public static function boot()
    {
        parent::boot();

        Category::observe(LogObserver::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }

    public function field()
    {
        return $this->belongsTo(FieldCategory::class, 'field_category_id');
    }

    public function listView()
    {
        return $this->belongsTo(Template::class, 'list_view_id');
    }

    public function detailView()
    {
        return $this->belongsTo(Template::class, 'detail_view_id');
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

    public function childs()
    {
        $query = $this->hasMany(Category::class, 'parent', 'id');

        return $query->orderBy('position', 'ASC');
    }

    public function childPublish()
    {
        return $this->hasMany(Category::class, 'parent', 'id')->publish()
            ->orderBy('position', 'ASC');
    }

    public function fieldLang($field, $lang = null)
    {
        if ($lang == null) {
            $lang = App::getLocale();
        }

        return $this->hasMany(Category::class, 'id')->first()[$field][$lang];
    }

    public function scopePublic($query)
    {
        return $query->where('public', 1);
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
            'public' => config('custom.label.optional.'.$this->public),
        ];

        return $config;
    }
}
