<?php

namespace App\Models\Page;

use App\Models\Configuration;
use App\Models\IndexUrl;
use App\Models\Master\Field\FieldCategory;
use App\Models\Master\Media;
use App\Models\Master\Template;
use App\Models\Menu\Menu;
use App\Models\User;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class Page extends Model
{
    use HasFactory;

    protected $table = 'pages';
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

        Page::observe(LogObserver::class);
    }

    public function indexing()
    {
        return $this->morphOne(IndexUrl::class, 'urlable');
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
        $query = $this->hasMany(Page::class, 'parent', 'id');

        return $query->orderBy('position', 'ASC');
    }

    public function childPublish()
    {
        return $this->hasMany(Page::class, 'parent', 'id')->publish()
            ->orderBy('position', 'ASC');
    }

    public function fieldLang($field, $lang = null)
    {
        if ($lang == null) {
            $lang = App::getLocale();
        }

        return $this->hasMany(Page::class, 'id')->first()[$field][$lang];
    }

    public function scopePublish($query)
    {
        return $query->where('publish', 1);
    }

    public function scopePublic($query)
    {
        return $query->where('public', 1);
    }

    public function coverSrc($type = 'default')
    {
        if (!empty($this->cover['file_path'])) {
            $cover = Storage::url($this->cover['file_path']);
        } else {

            if ($type == 'profile') {
                $cover = asset('assets/dummy/profile-empty.jpg');
            } else {
                $cover = asset(config('custom.files.cover.file'));
            }
            
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

    public function colorBidang()
    {
        if ($this->position == 1) {
            $color = 'btk';
        } elseif ($this->position == 2) {
            $color = 'brk';
        } elseif ($this->position == 3) {
            $color = 'bk';
        } elseif ($this->position == 4) {
            $color = 'bt';
        } elseif ($this->position == 5) {
            $color = 'bkp';
        } elseif ($this->position == 6) {
            $color = 'be';
        } elseif ($this->position == 7) {
            $color = 'bpk';
        } elseif ($this->position == 8) {
            $color = 'btie';
        } else {
            $color = 'btk';
        }

        return $color;
        
    }
}
