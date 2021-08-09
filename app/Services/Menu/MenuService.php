<?php

namespace App\Services\Menu;

use App\Models\Catalog\CatalogCategory;
use App\Models\Catalog\Product\CatalogProduct;
use App\Models\Content\Category;
use App\Models\Content\Post\Post;
use App\Models\Content\Section;
use App\Models\Gallery\Album;
use App\Models\Gallery\Playlist;
use App\Models\Inquiry\Inquiry;
use App\Models\Link\Link;
use App\Models\Menu\Menu;
use App\Models\Page\Page;
use App\Services\LanguageService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class MenuService
{
    private $model, $lang;

    public function __construct(
        Menu $model,
        LanguageService $lang
    )
    {
        $this->model = $model;
        $this->lang = $lang;
    }

    public function getMenuList($request, int $categoryId)
    {
        $query = $this->model->query();

        $query->where('menu_category_id', $categoryId);
        $query->when($request, function ($query, $req) {
            if ($req->s != '') {
                $query->where('publish', $req->s);
            }
        })->when($request, function ($query, $req) {
            if ($req->p != '') {
                $query->where('public', $req->p);
            }
        })->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('title->'.App::getLocale(), 'like', '%'.$q.'%');
            });
        });

        $limit = 20;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->where('parent', 0)->orderBy('position', 'ASC')
            ->paginate($limit);

        return $result;
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function store($request, int $categoryId)
    {
        $parent = $request->parent ?? 0;

        $menu = new Menu;
        $menu->menu_category_id = $categoryId;
        $menu->parent = $parent;
        $this->setField($request, $menu);
        $menu->position = $this->model->where('parent', (int)$parent)
            ->where('menu_category_id', $categoryId)->max('position') + 1;
        $menu->created_by = Auth::user()->id;
        $menu->save();

        return $menu;
    }

    public function update($request, int $id)
    {
        $menu = $this->find($id);
        $this->setField($request, $menu);
        $menu->save();

        return $menu;
    }

    public function setField($request, $menu)
    {
        //lang
        foreach ($this->lang->getLang(false, true) as $key => $value) {
            $title[$value->iso_codes] = ($request->input('title_'.$value->iso_codes) == null) ?
                $request->input('title_'.config('custom.language.default')) : $request->input('title_'.$value->iso_codes);
        }

        $menu->title = $title;
        $menu->attr = [
            'not_from_module' => (bool)$request->not_from_module,
            'url' => $request->url ?? null,
            'target_blank' => (bool)$request->target_blank,
        ];

        if ((bool)$request->not_from_module == 0) {
            $menu->module = $request->module ?? null;
            $this->checkModule($request, $menu);
        }
        
        $menu->edit_public_menu = (bool)$request->edit_public_menu;
        $menu->publish = (bool)$request->publish;
        $menu->public = (bool)$request->public;
        $menu->updated_by = Auth::user()->id;

        return $menu;
    }

    public function checkModule($request, $menu)
    {
        $id = $request->module_content;

        if ($request->module == 0) {
            $module = Page::find($id);
        } elseif ($request->module == 1) {
            $module = Section::find($id);
        } elseif ($request->module == 2) {
            $module = Category::find($id);
        } elseif ($request->module == 3) {
            $module = Post::find($id);
        } elseif ($request->module == 4) {
            $module = CatalogCategory::find($id);
        } elseif ($request->module == 5) {
            $module = CatalogProduct::find($id);
        } elseif ($request->module == 6) {
            $module = Album::find($id);
        } elseif ($request->module == 7) {
            $module = Playlist::find($id);
        } elseif ($request->module == 8) {
            $module = Link::find($id);
        } elseif ($request->module == 9) {
            $module = Inquiry::find($id);
        }

        return $menu->menuable()->associate($module);
    }

    public function publish(int $id)
    {
        $menu = $this->find($id);
        $menu->publish = !$menu->publish;
        $menu->save();

        return $menu;
    }

    public function position(int $id, int $position, int $parent = null)
    {
        if ($position >= 1) {

            $menu = $this->find($id);

            if ($parent != null) {
                $this->model->where('position', $position)->where('parent', $parent)->update([
                    'position' => $menu->position,
                ]);
            } else {
                $this->model->where('position', $position)->where('parent', 0)->update([
                    'position' => $menu->position,
                ]);
            }

            $menu->position = $position;
            $menu->save();

            return $menu;
        }
    }

    public function delete(int $id)
    {
        $menu = $this->find($id);

        if ($this->model->where('parent', $id)->count() == 0) {

            foreach ($this->model->where('parent', $id)->get() as $valueA) {

                $valueA->delete();
                foreach ($this->model->where('parent', $valueA->id)->get() as $valueB) {
                    $valueB->delete();
                }
            }

            $menu->delete();
            return true;

        } else {
            return false;
        }
    }
}