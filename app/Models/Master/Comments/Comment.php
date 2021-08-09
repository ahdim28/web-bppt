<?php

namespace App\Models\Master\Comments;

use App\Models\User;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        Comment::observe(LogObserver::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reply()
    {
        return $this->hasMany(CommentReply::class, 'comment_id');
    }

    public function deleteBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function scopeFlags($query)
    {
        return $query->where('flags', 1);
    }

    public function customConfig()
    {
        $config = [
            'flags' => config('custom.label.flags.'.$this->flags),
        ];

        return $config;
    }
}
