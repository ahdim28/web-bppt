<?php

namespace App\Models\Menu;

use App\Models\Catalog\CatalogCategory;
use App\Models\Catalog\Product\CatalogProduct;
use App\Models\Content\Category;
use App\Models\Content\Post\Post;
use App\Models\Content\Section;
use App\Models\Gallery\Album;
use App\Models\Gallery\Playlist;
use App\Models\Inquiry\Inquiry;
use App\Models\Link\Link;
use App\Models\Page\Page;
use App\Models\User;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';
    protected $guarded = [];

    protected $casts = [
        'title' => 'json',
        'attr' => 'json',
    ];

    public static function boot()
    {
        parent::boot();

        Menu::observe(LogObserver::class);
    }

    public function menuable()
    {
        return $this->morphTo();
    }

    public function category()
    {
        return $this->belongsTo(MenuCategory::class, 'menu_category_id');
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

    public function childs()
    {
        $query = $this->hasMany(Menu::class, 'parent', 'id');

        return $query->orderBy('position', 'ASC');
    }

    public function childPublish()
    {
        return $this->hasMany(Menu::class, 'parent', 'id')->publish()
            ->orderBy('position', 'ASC');
    }

    public function fieldLang($field, $lang = null)
    {
        if ($lang == null) {
            $lang = App::getLocale();
        }

        return $this->hasMany(Menu::class, 'id')->first()[$field][$lang];
    }

    public function modMenu()
    {
        $id = $this->menuable_id;
        $segment1 = request()->segment(1);
        $segment2 = request()->segment(2);
        $segment3 = request()->segment(3);
        if (App::getLocale() != config('custom.language.default')) {
            $segment1 = request()->segment(2);
            $segment2 = request()->segment(3);
            $segment3 = request()->segment(4);
        }

        if ($this->module == '0') {
            
            $model = Page::find($id);
            $module = [
                'title' => $this->fieldLang('title') ?? $model->fieldLang('title'),
                'routes' => route('page.read.'.$model->slug),
                'active' => ($segment1 == $model->slug) ? 'active' : '',
            ];

        } elseif ($this->module == 1) {

            $model = Section::find($id);
            $module = [
                'title' => $this->fieldLang('title') ?? $model->fieldLang('name'),
                'routes' => route('section.read.'.$model->slug),
                'active' => ($segment1 == $model->slug) ? 'active' : '',
            ];
            
        } elseif ($this->module == 2) {

            $model = Category::find($id);
            $module = [
                'title' => $this->fieldLang('title') ?? $model->fieldLang('name'),
                'routes' => route('category.read.'.$model->section->slug, ['slugCategory' => $model->slug]),
                'active' => ($segment1 == $model->section->slug && $segment2 == 'cat' 
                    && $segment3 == $model->slug) ? 'active' : '',
            ];
            
        } elseif ($this->module == 3) {

            $model = Post::find($id);
            $module = [
                'title' => $this->fieldLang('title') ?? $model->fieldLang('title'),
                'routes' => route('post.read.'.$model->section->slug, ['slugPost' => $model->slug]),
                'active' => ($segment1 == $model->section->slug && $segment2 == $model->slug) 
                    ? 'active' : '',
            ];
            
        } elseif ($this->module == 4) {

            $model = CatalogCategory::find($id);
            $module = [
                'title' => $this->fieldLang('title') ?? $model->fieldLang('name'),
                'routes' => route('catalog.category.read', ['slugCategory' => $model->slug]),
                'active' => ($segment1 == 'catalog' && $segment2 == 'cat' && 
                    $segment3 == $model->slug) ? 'active' : '',
            ];
            
        } elseif ($this->module == 5) {

            $model = CatalogProduct::find($id);
            $module = [
                'title' => $this->fieldLang('title') ?? $model->fieldLang('title'),
                'routes' => route('catalog.product.read', ['slugProduct' => $model->slug]),
                'active' => ($segment1 == 'catalog' && $segment2 == $model->slug) 
                    ? 'active' : '',
            ];
            
        } elseif ($this->module == 6) {

            $model = Album::find($id);
            $module = [
                'title' => $this->fieldLang('title') ?? $model->fieldLang('name'),
                'routes' => route('gallery.album.read', ['slugAlbum' => $model->slug]),
                'active' => ($segment1 == 'album' && $segment2 == $model->slug) ? 'active' : '',
            ];
            
        } elseif ($this->module == 7) {

            $model = Playlist::find($id);
            $module = [
                'title' => $this->fieldLang('title') ?? $model->fieldLang('name'),
                'routes' => route('gallery.playlist.read', ['slugPlaylist' => $model->slug]),
                'active' => ($segment1 == 'playlist' && $segment2 == $model->slug) ? 'active' : '',
            ];
            
        } elseif ($this->module == 8) {

            $model = Link::find($id);
            $module = [
                'title' => $this->fieldLang('title') ?? $model->fieldLang('name'),
                'routes' => route('link.read.'.$model->slug),
                'active' => ($segment1 == $model->slug) ? 'active' : '',
            ];
            
        } elseif ($this->module == 9) {

            $model = Inquiry::find($id);
            $module = [
                'title' => $this->fieldLang('title') ?? $model->fieldLang('name'),
                'routes' => route('inquiry.read.'.$model->slug),
                'active' => ($segment1 == $model->slug) ? 'active' : '',
            ];
            
        } else {

            $urlFull = URL::full();
            $url = url('/');
            $urlFix = Str::replace($url, '', $urlFull);
            $replace = $urlFix;
            if (request()->segment(1) == App::getLocale()) {
                $replace = Str::replace('/'.App::getLocale(), '', $urlFix);
            }

            $module = [
                'title' => $this->fieldLang('title'),
                'routes' => $this->attr['url'],
                'active' => $replace == $this->attr['url'] ? 'active' : '',
            ];
        }

        return $module;
    }

    public function scopePublish($query)
    {
        return $query->where('publish', 1);
    }

    public function scopePublic($query)
    {
        return $query->where('public', 1);
    }

    public function customConfig()
    {
        $config = [
            'publish' => config('custom.label.publish.'.$this->publish),
            'public' => config('custom.label.optional.'.$this->public),
        ];

        return $config;
    }
}
