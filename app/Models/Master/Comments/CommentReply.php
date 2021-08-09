<?php

namespace App\Models\Master\Comments;

use App\Models\User;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentReply extends Model
{
    use HasFactory;

    protected $table = 'comment_replies';
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        CommentReply::observe(LogObserver::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id');
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
