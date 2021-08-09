<?php

namespace App\Models\Content\Post;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostProfile extends Model
{
    use HasFactory;

    protected $table = 'content_post_profiles';
    protected $guarded = [];

    protected $casts = [
        'fields' => 'json',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
