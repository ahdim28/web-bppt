<?php

namespace App\Models\Catalog;

use App\Models\Catalog\Product\CatalogProduct;
use App\Models\User;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class CatalogType extends Model
{
    use HasFactory;

    protected $table = 'catalog_types';
    protected $guarded = [];

    protected $casts = [
        'name' => 'json',
        'description' => 'json',
    ];

    public static function boot()
    {
        parent::boot();

        CatalogType::observe(LogObserver::class);
    }

    public function products()
    {
        return $this->hasMany(CatalogProduct::class, 'catalog_type_id');
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

        return $this->hasMany(CatalogType::class, 'id')->first()[$field][$lang];
    }
}
