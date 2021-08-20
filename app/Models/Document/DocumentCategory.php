<?php

namespace App\Models\Document;

use App\Models\Configuration;
use App\Models\User;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class DocumentCategory extends Model
{
    use HasFactory;

    protected $table = 'document_categories';
    protected $guarded = [];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'banner' => 'array'
    ];

    public static function boot()
    {
        parent::boot();

        DocumentCategory::observe(LogObserver::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'category_id');
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
        $query = $this->hasMany(DocumentCategory::class, 'parent', 'id');

        return $query->orderBy('position', 'ASC');
    }

    public function childPublish()
    {
        return $this->hasMany(DocumentCategory::class, 'parent', 'id')->publish()
            ->orderBy('position', 'ASC');
    }

    public function fieldLang($field, $lang = null)
    {
        if ($lang == null) {
            $lang = App::getLocale();
        }

        return $this->hasMany(DocumentCategory::class, 'id')->first()[$field][$lang];
    }

    public function scopePublic($query)
    {
        return $query->where('public', 1);
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
            'public' => config('custom.label.optional.'.$this->public),
        ];

        return $config;
    }
}
