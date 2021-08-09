<?php

namespace App\Models\Gallery;

use App\Models\User;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class PlaylistVideo extends Model
{
    use HasFactory;

    protected $table = 'gallery_playlist_videos';
    protected $guarded = [];

    protected $casts = [
        'title' => 'json',
        'description' => 'json',
    ];

    public static function boot()
    {
        parent::boot();

        PlaylistVideo::observe(LogObserver::class);
    }

    public function playlist()
    {
        return $this->belongsTo(Playlist::class, 'playlist_id');
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

        return $this->hasMany(PlaylistVideo::class, 'id')->first()[$field][$lang];
    }

    public function fileSrc()
    {
        if ($this->is_youtube == 0) {

            if (!empty($this->thumbnail)) {
                $src = Storage::url(config('custom.files.gallery.video.thumbnail.path').
                    $this->playlist_id.'/'.$this->thumbnail);
            } else {
                $src = asset(config('custom.files.cover_playlist.file'));
            }

            $type = [
                'image' => $src,
                'video' => Storage::url(config('custom.files.gallery.video.path').
                    $this->playlist_id.'/'.$this->file),
                'name' => 'VIDEO'
            ];

        } else {            

            $type = [
                'image' => 'https://i.ytimg.com/vi/'.$this->youtube_id.'/mqdefault.jpg',
                'video' => 'https://www.youtube.com/embed/'.$this->youtube_id.'?rel=0;showinfo=0',
                'name' => 'YOUTUBE VIDEO'
            ];
        }

        return $type;
    }
}
