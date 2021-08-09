<?php

namespace App\Models\Inquiry;

use App\Models\User;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class InquiryField extends Model
{
    use HasFactory;

    protected $table = 'inquiry_fields';
    protected $guarded = [];

    protected $casts = [
        'label' => 'json',
        'properties' => 'json',
    ];

    public static function boot()
    {
        parent::boot();

        InquiryField::observe(LogObserver::class);
    }

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class, 'inquiry_id');
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

    public function fieldLang($field, $lang = null)
    {
        if ($lang == null) {
            $lang = App::getLocale();
        }

        return $this->hasMany(InquiryField::class, 'id')->first()[$field][$lang];
    }

    public function customConfig()
    {
        $config = [
            'type' => config('custom.field.field_inquiry.'.$this->type),
        ];

        return $config;
    }
}
