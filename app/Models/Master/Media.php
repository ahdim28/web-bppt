<?php

namespace App\Models\Master;

use App\Models\User;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    protected $table = 'medias';
    protected $guarded = [];

    protected $casts = [
        'file_path' => 'json',
        'caption' => 'json',
    ];

    public static function boot()
    {
        parent::boot();

        Media::observe(LogObserver::class);
    }

    public function mediable()
    {
        return $this->morphTo();
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

    public function scopeYoutube($query)
    {
        return $query->where('is_youtube', 1);
    }

    public function fileSrc()
    {
        return Storage::url($this->file_path['filename']);
    }

    public function getExtension($file)
    {
        return pathinfo(Storage::url($file))['extension'];
    }

    public function icon()
    {
        $type = $this->getExtension($this->file_path['filename']);

        if ($type == 'jpg' || $type == 'jpeg' || $type == 'png' ||
            $type == 'svg' || $type == 'jpg') {
            $ext = 'image';
        } elseif ($type == 'mp4' || $type == 'webm') {
            $ext = 'video';
        } elseif ($type == 'mp3') {
            $ext = 'audio';
        } elseif ($type == 'pdf') {
            $ext = 'pdf';
        } elseif ($type == 'doc' || $type == 'docx') {
            $ext = 'word';
        } elseif ($type == 'ppt' || $type == 'pptx') {
            $ext = 'powerpoint';
        } elseif ($type == 'xls' || $type == 'xlsx') {
            $ext = 'excel';
        } else {
            $ext = 'alt';
        }

        return $ext;
    }
}
