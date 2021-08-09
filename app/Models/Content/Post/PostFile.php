<?php

namespace App\Models\Content\Post;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PostFile extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = 'content_post_files';
    protected $guarded = [];
    protected $casts = [
        'caption' => 'json',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function filePath()
    {
        return Storage::url(config('custom.files.post_files.path').$this->post_id.'/'.
            $this->file);
    }
}
