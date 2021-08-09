<?php

namespace App\Models\Inquiry;

use App\Models\Configuration;
use App\Models\IndexUrl;
use App\Models\Menu\Menu;
use App\Models\User;
use App\Observers\LogObserver;
use App\Services\Master\Field\FieldCategoryService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class Inquiry extends Model
{
    use HasFactory;

    protected $table = 'inquiries';
    protected $guarded = [];

    protected $casts = [
        'name' => 'json',
        'body' => 'json',
        'after_body' => 'json',
        'banner' => 'json',
        'email' => 'array',
        'meta_data' => 'json',
        'custom_field' => 'json'
    ];

    public static function boot()
    {
        parent::boot();

        Inquiry::observe(LogObserver::class);
    }

    public function indexing()
    {
        return $this->morphOne(IndexUrl::class, 'urlable');
    }

    public function forms()
    {
        return $this->hasMany(InquiryForm::class, 'inquiry_id');
    }

    public function inquiryField()
    {
        return $this->hasMany(InquiryField::class, 'inquiry_id');
    }

    public function field()
    {
        return $this->belongsTo(FieldCategoryService::class, 'field_category_id');
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

        return $this->hasMany(Inquiry::class, 'id')->first()[$field][$lang];
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

    public function mailStr()
    {
        $email = $this->email;

        $str['implode'] = implode(",", $email);

        return $str;
    }

    public function customConfig()
    {
        $config = [
            'publish' => config('custom.label.publish.'.$this->publish)
        ];

        return $config;
    }
}
