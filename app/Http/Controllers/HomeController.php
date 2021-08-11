<?php

namespace App\Http\Controllers;

use App\Services\Banner\BannerCategoryService;
use App\Services\Catalog\CatalogCategoryService;
use App\Services\Catalog\Product\CatalogProductService;
use App\Services\ConfigurationService;
use App\Services\Content\CategoryService;
use App\Services\Content\PostService;
use App\Services\Content\SectionService;
use App\Services\Gallery\AlbumService;
use App\Services\Gallery\PlaylistService;
use App\Services\Inquiry\InquiryService;
use App\Services\Link\LinkService;
use App\Services\NotificationService;
use App\Services\Page\PageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    private $page, $section, $category, $post, $bannerCategory, $catalogCategory,
        $catalogProduct, $album, $playlist, $links, $inquiry, $config, $notification;

    public function __construct(
        PageService $page,
        SectionService $section,
        CategoryService $category,
        PostService $post,
        BannerCategoryService $bannerCategory,
        CatalogCategoryService $catalogCategory,
        CatalogProductService $catalogProduct,
        AlbumService $album,
        PlaylistService $playlist,
        LinkService $links,
        InquiryService $inquiry,
        ConfigurationService $config,
        NotificationService $notification
    )
    {
        $this->page = $page;
        $this->section = $section;
        $this->category = $category;
        $this->post = $post;
        $this->bannerCategory = $bannerCategory;
        $this->catalogCategory = $catalogCategory;
        $this->catalogProduct = $catalogProduct;
        $this->album = $album;
        $this->playlist = $playlist;
        $this->links = $links;
        $this->inquiry = $inquiry;
        $this->config = $config;
        $this->notification = $notification;
    }

    public function landing(Request $request)
    {
        return redirect()->route('home');
        
        $data['data'] = null;

        return view('frontend.landing', compact('data'));
    }

    public function home(Request $request)
    {
        $data['news_selected'] = $this->post->getPost(null, null, 4, null, null)
            ->where('selection', 1);
        $data['pengantar'] = $this->page->getPage(null, null, null)->where('id', 8)->first();
        $data['penugasan'] = $this->page->getPage(null, null, null)->where('id', 3)->first();
        $data['kecerdasan'] = $this->page->getPage(null, null, null)->where('id', 5)->first();
        $data['p3dn'] = $this->page->getPage(null, null, null)->where('id', 6)->first();
        $data['digital'] = $this->page->getPage(null, null, null)->where('id', 7)->first();
        $data['link'] = $this->links->getLink(null, null, null)->where('id', 1)->first();

        return view('frontend.index', compact('data'));
    }

    public function search(Request $request)
    {
        // if ($request->get('keyword') == '') {
        //     return redirect()->route('home');
        // }

        $data['pages'] = $this->page->getPage($request);
        $data['sections'] = $this->section->getSection($request);
        $data['categories'] = $this->category->getCategory($request);
        $data['posts'] = $this->post->getPost($request);
        $data['catalog_categories'] = $this->catalogCategory->getCatalogCategory($request);
        $data['catalog_products'] = $this->catalogProduct->getCatalogProduct($request);

        return view('frontend.search', compact('data'), [
            'title' => 'Search',
            'breadcrumbs' => [

            ],
        ]);
    }

    public function downloadPanduan()
    {
        $panduan = $this->config->getValue('panduan_identitas');

        $file = storage_path('app/public/config/'.$panduan);

        return response()->download($file);
    }

    public function sitemap(Request $request)
    {
        $data['pages'] = $this->page->getPage($request);
        $data['sections'] = $this->section->getSection($request);
        $data['categories'] = $this->category->getCategory($request);
        $data['posts'] = $this->post->getPost($request);
        $data['catalog_categories'] = $this->catalogCategory->getCatalogCategory($request);
        $data['catalog_products'] = $this->catalogProduct->getCatalogProduct($request);
        $data['albums'] = $this->album->getAlbum($request);
        $data['playlists'] = $this->playlist->getPlaylist($request);
        $data['links'] = $this->links->getLink($request);
        $data['inquiries'] = $this->inquiry->getInquiry($request);

        return response()->view('frontend.sitemap', compact('data'))
            ->header('Content-Type', 'text/xml');
    }

    public function feed(Request $request)
    {
        $data['title'] = $this->config->getValue('meta_title');
        $data['description'] = $this->config->getValue('meta_description');
        $data['posts'] = $this->post->getPost($request);

        return view('frontend.rss.feed', compact('data'));
    }

    public function post(Request $request)
    {
        $data['title'] = $this->config->getValue('meta_title');
        $data['description'] = $this->config->getValue('meta_description');
        $data['posts'] = $this->post->getPost($request);

        return view('frontend.rss.post', compact('data'));
    }

    public function maintenance()
    {
        if (config('custom.maintenance.mode') == FALSE) {
            return redirect()->route('home');
        }

        return view('frontend.maintenance');
    }
}
