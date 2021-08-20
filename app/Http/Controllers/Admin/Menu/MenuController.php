<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\MenuRequest;
use App\Services\Catalog\CatalogCategoryService;
use App\Services\Catalog\Product\CatalogProductService;
use App\Services\Content\CategoryService;
use App\Services\Content\PostService;
use App\Services\Content\SectionService;
use App\Services\Gallery\AlbumService;
use App\Services\Gallery\PlaylistService;
use App\Services\Inquiry\InquiryService;
use App\Services\LanguageService;
use App\Services\Link\LinkService;
use App\Services\Menu\MenuCategoryService;
use App\Services\Menu\MenuService;
use App\Services\Page\PageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    private $service, $serviceCategory, $page, $section, $category, $post, $catalogCategory, 
        $catalogProduct, $album, $playlist, $link, $inquiry, $serviceLang;

    public function __construct(
        MenuService $service,
        MenuCategoryService $serviceCategory,
        PageService $page,
        SectionService $section,
        CategoryService $category,
        PostService $post,
        CatalogCategoryService $catalogCategory,
        CatalogProductService $catalogProduct,
        AlbumService $album,
        PlaylistService $playlist,
        LinkService $link,
        InquiryService $inquiry,
        LanguageService $serviceLang
    )
    {
        $this->service = $service;
        $this->serviceCategory = $serviceCategory;
        $this->page = $page;
        $this->section = $section;
        $this->category = $category;
        $this->post = $post;
        $this->catalogCategory = $catalogCategory;
        $this->catalogProduct = $catalogProduct;
        $this->album = $album;
        $this->playlist = $playlist;
        $this->link = $link;
        $this->inquiry = $inquiry;
        $this->serviceLang = $serviceLang;

        $this->lang = config('custom.language.multiple');
    }

    public function index(Request $request, $categoryId)
    {
        $url = $request->url();
        $param = Str::replace($url, '', $request->fullUrl());

        $data['menus'] = $this->service->getMenuList($request, $categoryId);
        $data['no'] = $data['menus']->firstItem();
        $data['menus']->withPath(url()->current().$param);
        $data['category'] = $this->serviceCategory->find($categoryId);

        return view('backend.menu.index', compact('data'), [
            'title' => __('mod/menu.title'),
            'routeBack' => route('menu.category.index'),
            'breadcrumbs' => [
                __('mod/menu.category.caption') => route('menu.category.index'),
                __('mod/menu.title') => '',
            ]
        ]);
    }

    public function create(Request $request, $categoryId)
    {
        $data['category'] = $this->serviceCategory->find($categoryId);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);
        if (isset($request->parent)) {
            $data['parent'] = $this->service->find($request->parent);
        }

        //module
        $data['pages'] = $this->page->getPage();
        $data['sections'] = $this->section->getSection();
        $data['categories'] = $this->category->getCategory();
        // $data['posts'] = $this->post->getPost();
        // $data['cat_categories'] = $this->catalogCategory->getCatalogCategory();
        // $data['cat_products'] = $this->catalogProduct->getCatalogProduct();
        // $data['albums'] = $this->album->getAlbum();
        // $data['playlists'] = $this->playlist->getPlaylist();
        // $data['links'] = $this->link->getLink();
        $data['inquiries'] = $this->inquiry->getInquiry();

        return view('backend.menu.form', compact('data'), [
            'title' =>  __('lang.add_attr_new', [
                'attribute' => __('mod/menu.title')
            ]),
            'routeBack' => route('menu.index', ['categoryId' => $categoryId]),
            'breadcrumbs' => [
                __('mod/menu.category.caption') => route('menu.category.index'),
                __('mod/menu.title') => route('menu.index', ['categoryId' => $categoryId]),
                __('lang.add') => '',
            ],
        ]);
    }

    public function store(MenuRequest $request, $categoryId)
    {
        $this->service->store($request, $categoryId);

        $redir = $this->redirectForm($request, $categoryId);
        return $redir->with('success', __('alert.create_success', [
            'attribute' => __('mod/menu.title')
        ]));
    }

    public function edit(Request $request, $categoryId, $id)
    {
        $data['menu'] = $this->service->find($id);
        $data['category'] = $this->serviceCategory->find($categoryId);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);

        if (!Auth::user()->hasRole('super') && $data['menu']->edit_public_menu == 0) {
            return abort(403);
        }

        //module
        $data['pages'] = $this->page->getPage();
        $data['sections'] = $this->section->getSection();
        $data['categories'] = $this->category->getCategory();
        // $data['posts'] = $this->post->getPost();
        // $data['cat_categories'] = $this->catalogCategory->getCatalogCategory();
        // $data['cat_products'] = $this->catalogProduct->getCatalogProduct();
        // $data['albums'] = $this->album->getAlbum();
        // $data['playlists'] = $this->playlist->getPlaylist();
        // $data['links'] = $this->link->getLink();
        $data['inquiries'] = $this->inquiry->getInquiry();

        return view('backend.menu.form-edit', compact('data'), [
            'title' =>  __('lang.edit_attr', [
                'attribute' => __('mod/menu.title')
            ]),
            'routeBack' => route('menu.index', ['categoryId' => $categoryId]),
            'breadcrumbs' => [
                __('mod/menu.category.caption') => route('menu.category.index'),
                __('mod/menu.title') => route('menu.index', ['categoryId' => $categoryId]),
                __('lang.edit') => '',
            ],
        ]);
    }

    public function update(MenuRequest $request, $categoryId, $id)
    {
        $this->service->update($request, $id);

        $redir = $this->redirectForm($request, $categoryId);
        return $redir->with('success', __('alert.update_success', [
            'attribute' => __('mod/menu.title')
        ]));
    }

    public function publish($categoryId, $id)
    {
        $this->service->publish($id);

        return back()->with('success', __('alert.update_success', [
            'attribute' => __('mod/menu.title')
        ]));
    }

    public function position(Request $request, $categoryId, $id, $position)
    {
        $this->service->position($id, $position, $request->get('parent'));

        return back()->with('success', __('lang.position_change', [
            'attribute' => __('mod/menu.title')
        ]));
    }

    public function destroy($categoryId, $id)
    {
        $delete = $this->service->delete($id);

        if ($delete == true) {

            return response()->json([
                'success' => 1,
                'message' => ''
            ], 200);

        } else {

            return response()->json([
                'success' => 0,
                'message' => __('alert.delete_failed_used', [
                    'attribute' => __('mod/menu.title')
                ])
            ], 200);
        }
    }

    public function redirectForm($request, $categoryId)
    {
        $redir = redirect()->route('menu.index', ['categoryId' => $categoryId]);
        if ($request->action == 'back') {
            $redir = back();
        }

        return $redir;
    }
}
