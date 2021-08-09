<?php

namespace App\Models\Master;

use App\Models\Catalog\CatalogCategory;
use App\Models\Catalog\Product\CatalogProduct;
use App\Models\Content\Category;
use App\Models\Content\Post\Post;
use App\Models\Content\Section;
use App\Models\Gallery\Album;
use App\Models\Gallery\Playlist;
use App\Models\Link\Link;
use App\Models\Page\Page;
use App\Models\User;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $table = 'templates';
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        Template::observe(LogObserver::class);
    }

    public function pages()
    {
        return $this->hasMany(Page::class, 'custom_view_id');
    }

    public function sectionList()
    {
        return $this->hasMany(Section::class, 'list_view_id');
    }

    public function sectionDetail()
    {
        return $this->hasMany(Section::class, 'detail_view_id');
    }

    public function categoryList()
    {
        return $this->hasMany(Category::class, 'list_view_id');
    }

    public function categoryDetail()
    {
        return $this->hasMany(Category::class, 'detail_view_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'custom_view_id');
    }

    public function catalogCategories()
    {
        return $this->hasMany(CatalogCategory::class, 'custom_view_id');
    }

    public function catalogProducts()
    {
        return $this->hasMany(CatalogProduct::class, 'custom_view_id');
    }

    public function albums()
    {
        return $this->hasMany(Album::class, 'custom_view_id');
    }

    public function playlists()
    {
        return $this->hasMany(Playlist::class, 'custom_view_id');
    }

    public function links()
    {
        return $this->hasMany(Link::class, 'custom_view_id');
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
            'module' => config('custom.templates.module.'.$this->module),
            'type' => config('custom.templates.type.'.$this->type),
            'path' => config('custom.templates.path.'.$this->path),
        ];

        return $config;
    }
}
