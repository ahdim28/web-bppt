<?php

namespace App\Models\Master\Tags;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagType extends Model
{
    use HasFactory;

    protected $table = 'tag_types';
    protected $guarded = [];

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }

    public function tagable()
    {
        return $this->morphTo();
    }
}
