<?php

namespace App\Models\Gallery;

use App\Models\User;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class AlbumPhoto extends Model
{
    use HasFactory;

    protected $table = 'gallery_album_photos';
    protected $guarded = [];

    protected $casts = [
        'title' => 'json',
        'description' => 'json',
    ];

    public static function boot()
    {
        parent::boot();

        AlbumPhoto::observe(LogObserver::class);
    }

    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id');
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

        return $this->hasMany(AlbumPhoto::class, 'id')->first()[$field][$lang];
    }

    public function photoSrc()
    {
        return Storage::url(config('custom.files.gallery.photo.path').$this->album_id.'/'.
            $this->file);
    }
}
