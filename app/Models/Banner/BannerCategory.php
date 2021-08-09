<?php

namespace App\Models\Banner;

use App\Models\Configuration;
use App\Models\Master\Field\FieldCategory;
use App\Models\User;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class BannerCategory extends Model
{
    use HasFactory;

    protected $table = 'banner_categories';
    protected $guarded = [];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'custom_field' => 'array'
    ];

    public static function boot()
    {
        parent::boot();

        BannerCategory::observe(LogObserver::class);
    }

    public function banners()
    {
        return $this->hasMany(Banner::class, 'banner_category_id');
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

    public function bannerPublish($id)
    {
        $find = BannerCategory::find($id);
        $limit = Configuration::value('banner_limit');
        if (!empty($find->banner_limit)) {
            $limit = $find->banner_limit;
        }

        return $this->hasMany(Banner::class, 'banner_category_id')
            ->where('publish', 1)
            ->orderBy('position', 'ASC')->limit($limit);
    }

    public function fieldLang($field, $lang = null)
    {
        if ($lang == null) {
            $lang = App::getLocale();
        }

        return $this->hasMany(BannerCategory::class, 'id')->first()[$field][$lang];
    }
}
