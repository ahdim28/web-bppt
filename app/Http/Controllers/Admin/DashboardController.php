<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Banner\BannerCategoryService;
use App\Services\Catalog\CatalogCategoryService;
use App\Services\Catalog\Product\CatalogProductService;
use App\Services\ConfigurationService;
use App\Services\Content\CategoryService;
use App\Services\Content\PostService;
use App\Services\Content\SectionService;
use App\Services\Gallery\AlbumService;
use App\Services\Gallery\PhotoService;
use App\Services\Gallery\PlaylistService;
use App\Services\Gallery\VideoService;
use App\Services\Inquiry\InquiryService;
use App\Services\Link\LinkService;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Analytics\Period;
use Analytics;
use App\Services\Page\PageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    private $page, $section, $category, $post, $bannerCategory, $catalogCategory,
        $catalogProduct, $album, $photo, $playlist, $video, $links, $inquiry, $config, 
        $notification;

    public function __construct(
        PageService $page,
        SectionService $section,
        CategoryService $category,
        PostService $post,
        BannerCategoryService $bannerCategory,
        CatalogCategoryService $catalogCategory,
        CatalogProductService $catalogProduct,
        AlbumService $album,
        PhotoService $photo,
        PlaylistService $playlist,
        VideoService $video,
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
        $this->photo = $photo;
        $this->playlist = $playlist;
        $this->video = $video;
        $this->links = $links;
        $this->inquiry = $inquiry;
        $this->config = $config;
        $this->notification = $notification;
    }

    public function index(Request $request)
    {
        if (!Auth::user()->hasRole('super|support|admin')) {
            return redirect()->route('home');
        }

        $data['counter'] = [
            'pages' => $this->page->count(),
            'sections' => $this->section->count(),
            'categories' => $this->category->count(),
            'posts' => $this->post->count(),
            'albums' => $this->album->count(),
            'photos' => $this->photo->count(),
            'playlists' => $this->playlist->count(),
            'videos' => $this->video->count(),
        ];
        $data['lists'] = [
            'posts' => $this->post->getPost(null, null, 5),
            'inquiries' => $this->inquiry->latestForm(),
        ];

        if (!empty(env('ANALYTICS_VIEW_ID'))) {
            $periode = Period::days(7);
            $data['total'] = Analytics::fetchTotalVisitorsAndPageViews($periode);

            $graphLabel = [];
            $graphVisitor = [];
            foreach ($data['total'] as $key => $value) {
                $graphLabel[$key] = Carbon::parse($value['date'])->format('d F');
                $graphVisitor[$key] = $value['visitors'];
            }

            $data['graph_visitor'] = [
                'label' => $graphLabel,
                'visitor' => $graphVisitor 
            ];
        }

        return view('backend.dashboard', compact('data'), [
            'title' => __('mod/dashboard.title'),
        ]);
    }

    public function notification(Request $request)
    {
        if (!Auth::user()->hasRole('super|support|admin')) {
            return redirect()->route('home');
        }
        
        $url = $request->url();
        $param = Str::replace($url, '', $request->fullUrl());

        $data['notifications'] = $this->notification->getNotificationList($request, Auth::user()->id);
        $data['no'] = $data['notifications']->firstItem();
        $data['notifications']->withPath(url()->current().$param);

        return view('backend.notification', compact('data'), [
            'title' => __('mod/setting.notification.title'),
            'breadcrumbs' => [
                __('mod/setting.notification.caption') => '',
            ]
        ]);
    }

    public function apiNotif()
    {
        $total = $this->notification->totalUnread(Auth::user()->id);
        $latest = $this->notification->latestNotification(Auth::user()->id);

        $list = [];
        foreach ($latest as $key => $value) {
            $list[$key] = [
                'id' => $value->id,
                'from' => !empty($value->user_from) ? $value->userFrom->name : 'Visitor',
                'icon' => $value->attribute['icon'],
                'color' => $value->attribute['color'],
                'title' => $value->attribute['title'],
                'content' => $value->attribute['content'],
                'link' => $value->link,
                'date' => $value->created_at->diffForHumans()
            ];
        }

        return response()->json([
            'total' => $total,
            'latest' => $list
        ], 200);
    }
}
