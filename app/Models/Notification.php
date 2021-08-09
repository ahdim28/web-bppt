<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    protected $guarded = [];

    protected $casts = [
        'user_to' => 'array',
        'attribute' => 'json',
        'read_by' => 'array',
    ];

    public function userFrom()
    {
        return $this->belongsTo(User::class, 'user_from');
    }
}
