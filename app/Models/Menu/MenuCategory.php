<?php

namespace App\Models\Menu;

use App\Models\User;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MenuCategory extends Model
{
    use HasFactory;

    protected $table = 'menu_categories';
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        MenuCategory::observe(LogObserver::class);
    }

    public function menu()
    {
        return $this->hasMany(Menu::class, 'menu_category_id');
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

    public function getMenu($id)
    {
        $query = Menu::query();

        $query->where('menu_category_id', $id)->where('parent', 0);
        $query->publish();

        if (Auth::guard()->check() == false) {
            $query->public();
        }

        $result = $query->orderBy('position', 'ASC')->get();

        return $result;
    }
}
