<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Configuration extends Model
{
    use HasFactory;

    protected $table = 'configurations';
    protected $primaryKey = 'name';
    protected $guarded = [];

    public $incrementing = false;
    public $timestamps = false;

    public function scopeUpload($query)
    {
        return $query->where('is_upload', 1);
    }

    static function value($name)
    {
        return Configuration::select('value')->where('name', $name)->first()->value;
    }

    static function file($name)
    {
        $config = Configuration::select('value')->where('name', $name)->first();

        if (!empty($config->value)) {
            $file = Storage::url(config('custom.files.config.path').$config->value);
        } else {
            $file = asset(config('custom.files.config.'.$name.'.file'));
        }

        return $file;
    }
}
