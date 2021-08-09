<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndexUrl extends Model
{
    use HasFactory;

    protected $table = 'index_urls';
    protected $guarded = [];

    public function urlable()
    {
        return $this->morphTo();
    }
}
