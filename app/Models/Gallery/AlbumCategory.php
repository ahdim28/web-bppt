<?php

namespace App\Models\Gallery;

use App\Models\User;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class AlbumCategory extends Model
{
    use HasFactory;

    protected $table = 'gallery_album_categories';
    protected $guarded = [];

    protected $casts = [
        'name' => 'json',
        'description' => 'json',
    ];

    public static function boot()
    {
        parent::boot();

        AlbumCategory::observe(LogObserver::class);
    }

    public function albums()
    {
        return $this->hasMany(Album::class, 'category_id');
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

        return $this->hasMany(AlbumCategory::class, 'id')->first()[$field][$lang];
    }
}
