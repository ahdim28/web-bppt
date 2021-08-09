<?php

namespace App\Models\Master\Field;

use App\Models\Catalog\CatalogCategory;
use App\Models\Catalog\Product\CatalogProduct;
use App\Models\Content\Category;
use App\Models\Content\Post\Post;
use App\Models\Content\Section;
use App\Models\Gallery\Album;
use App\Models\Gallery\Playlist;
use App\Models\Inquiry\Inquiry;
use App\Models\Link\Link;
use App\Models\Link\LinkMedia;
use App\Models\Page\Page;
use App\Models\User;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldCategory extends Model
{
    use HasFactory;

    protected $table = 'field_categories';
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        FieldCategory::observe(LogObserver::class);
    }

    public function fields()
    {
        return $this->hasMany(Field::class, 'category_id');
    }

    public function pages()
    {
        return $this->hasMany(Page::class, 'field_category_id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class, 'field_category_id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'field_category_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'field_category_id');
    }

    public function catalogCategories()
    {
        return $this->hasMany(CatalogCategory::class, 'field_category_id');
    }

    public function catalogProducts()
    {
        return $this->hasMany(CatalogProduct::class, 'field_category_id');
    }

    public function albums()
    {
        return $this->hasMany(Album::class, 'field_category_id');
    }

    public function playlists()
    {
        return $this->hasMany(Playlist::class, 'field_category_id');
    }

    public function links()
    {
        return $this->hasMany(Link::class, 'field_category_id');
    }

    public function linkMedia()
    {
        return $this->hasMany(LinkMedia::class, 'field_category_id');
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class, 'field_category_id');
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
}
