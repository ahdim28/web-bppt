<?php

namespace App\Models\Inquiry;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InquiryForm extends Model
{
    use HasFactory;

    protected $table = 'inquiry_forms';
    protected $guarded = [];

    protected $casts = [
        'fields' => 'json',
        'submit_time' => 'datetime'
    ];

    public $timestamps = false;

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class, 'inquiry_id');
    }

    public function scopeRead($query)
    {
        return $query->where('status', 1);
    }

    public function scopeExport($query)
    {
        return $query->where('exported', 1);
    }

    public function customConfig()
    {
        $config = [
            'read' => config('custom.label.read.'.$this->status),
            'export' => config('custom.label.optional.'.$this->exported),
        ];

        return $config;
    }
}
