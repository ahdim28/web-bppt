<?php

namespace App\Models\Master\Field;

use App\Models\User;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $table = 'fields';
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        Field::observe(LogObserver::class);
    }

    public function category()
    {
        return $this->belongsTo(FieldCategory::class, 'category_id');
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

    public function customConfig()
    {
        $config = [
            'module' => config('custom.field.field_module.'.$this->type),
        ];

        return $config;
    }
}
