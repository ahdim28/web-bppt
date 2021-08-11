<?php

namespace App\Models\Deputi;

use App\Models\User;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class StructureOrganization extends Model
{
    use HasFactory;

    protected $table = 'structure_organizations';
    protected $guarded = [];

    protected $casts = [
        'name' => 'json',
        'description' => 'json',
    ];

    public static function boot()
    {
        parent::boot();

        StructureOrganization::observe(LogObserver::class);
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

        return $this->hasMany(StructureOrganization::class, 'id')->first()[$field][$lang];
    }
}
