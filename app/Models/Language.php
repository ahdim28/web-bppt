<?php

namespace App\Models;

use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class Language extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'languages';
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        Language::observe(LogObserver::class);
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

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function upperField($value)
    {
        return Str::upper($value);
    }

    public function urlSwitcher()
    {
        $url = Str::replaceFirst('en', '', Str::replaceFirst('en/', '', 
            Str::replace(url(''), '', URL::full())));
        if ($this->iso_codes != config('custom.language.default')) {
            $varCode = '';
            if (App::getLocale() != $this->iso_codes) {
                $varCode = '/'.$this->iso_codes;
            }
            $url = Str::replace(url('/'), $varCode, URL::full());
        }

        return $url;
    }

    public function image()
    {
        return Storage::url($this->icon);
    }

    public function customConfig()
    {
        $config = [
            'active' => config('custom.label.active.'.$this->status),
        ];

        return $config;
    }

    public function flags($style = 'flat', $size = 64)
    {
        $iso = $this->iso_codes;
        if ($iso == 'en') {
            $iso = 'gb';
        }

        return 'https://www.countryflags.io/'.$iso.'/'.$style.'/'.$size.'.png';
    }
}
