<?php

namespace App\Http\Controllers;

use App\Services\ConfigurationService;
use App\Services\Gallery\AlbumCategoryService;
use App\Services\Gallery\AlbumService;
use App\Services\Gallery\PhotoService;
use App\Services\Gallery\PlaylistCategoryService;
use App\Services\Gallery\PlaylistService;
use App\Services\Gallery\VideoService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryViewController extends Controller
{
    private $serviceCatAlbum, $serviceAlbum, $servicePhoto, $serviceCatPlaylist, $servicePlaylist, $serviceVideo, $config;

    public function __construct(
        AlbumCategoryService $serviceCatAlbum,
        AlbumService $serviceAlbum,
        PhotoService $servicePhoto,
        PlaylistCategoryService $serviceCatPlaylist,
        PlaylistService $servicePlaylist,
        VideoService $serviceVideo,
        ConfigurationService $config
    )
    {
        $this->serviceCatAlbum = $serviceCatAlbum;
        $this->serviceAlbum = $serviceAlbum;
        $this->servicePhoto = $servicePhoto;
        $this->serviceCatPlaylist = $serviceCatPlaylist;
        $this->servicePlaylist = $servicePlaylist;
        $this->serviceVideo = $serviceVideo;
        $this->config = $config;
    }

    public function list(Request $request)
    {
        return redirect()->route('home');
        
        $data['banner'] = $this->config->getFile('banner_default');
        $limit = $this->config->getValue('content_limit');
        $data['album'] = $this->serviceAlbum->getAlbum($request, true, $limit);
        $data['playlist'] = $this->servicePlaylist->getPlaylist($request, true, $limit);

        return view('frontend.gallery.index', compact('data'), [
            'title' => __('common.gallery_caption'),
            'breadcrumbs' => [
                __('common.gallery_caption') => ''
            ],
        ]);
    }

    /**
     * album
     */
    public function listCatAlbum(Request $request)
    {
        $url = $request->url();
        $param = Str::replace($url, '', $request->fullUrl());
        $data['banner'] = $this->config->getFile('banner_default');
        $limit = $this->config->getValue('content_limit');

        $data['categories'] = $this->serviceCatAlbum->getAlbumCategory(null, true, $limit);
        $data['albums'] = $this->serviceAlbum->getAlbum($request, true, $limit);
        $data['photos'] = $this->servicePhoto->getPhoto($request, true, $limit);

        return view('frontend.gallery.albums.list', compact('data'), [
            'title' => __('common.gallery_caption').' '.__('common.photo_caption'),
            'breadcrumbs' => [
                __('common.gallery_caption') => route('gallery.list'),
                __('common.photo_caption') => ''
            ],
        ]);
    }

    public function readCatAlbum(Request $request)
    {
        $slug = $request->route('slugCategory');

        $data['read'] = $this->serviceCatAlbum->findBySlug($slug);

        //check
        if (empty($slug)) {
            return abort(404);
        }

        if ($data['read']->publish == 0 || empty($data['read'])) {
            return redirect()->route('home');
        }

        $limit = $this->config->getValue('content_limit');

        $data['albums'] = $this->serviceAlbum->getAlbum($request, true, $limit, $data['read']->id);
        $data['photos'] = $this->servicePhoto->getPhoto($request, true, $limit, $data['read']->id, null);

        // meta data
        $data['meta_title'] = $data['read']->fieldLang('name');
        $data['meta_description'] = $this->config->getValue('meta_description');
        if (!empty($data['read']->fieldLang('description'))) {
            $data['meta_description'] = Str::limit(strip_tags($data['read']->fieldLang('description')), 155);
        }

        //images
        $data['creator'] = $data['read']->createBy->name;
        $data['cover'] = $data['read']->imgPreview();
        $data['banner'] = $this->config->getFile('banner_default');

        return view('frontend.gallery.albums.category', compact('data'), [
            'title' => $data['read']->fieldLang('name'),
            'breadcrumbs' => [
                __('common.gallery_caption') => route('gallery.list'),
                __('common.photo_caption') => route('gallery.photo'),
                Str::limit($data['read']->fieldLang('name'), 15) => ''
            ],
        ]);
    }

    public function readAlbum(Request $request)
    {
        $slug = $request->route('slugAlbum');

        $data['read'] = $this->serviceAlbum->findBySlug($slug);

        //check
        if (empty($slug)) {
            return abort(404);
        }

        if ($data['read']->publish == 0 || empty($data['read']) || $data['read']->is_detail == 0) {
            return redirect()->route('home');
        }

        //data
        $limit = $this->config->getValue('content_limit');
        if (!empty($data['read']->photo_limit)) {
            $limit = $data['read']->photo_limit;
        }
        $data['photo'] = $this->servicePhoto->getPhoto($request, false, null, null, $data['read']->id);

        // meta data
        $data['meta_title'] = $data['read']->fieldLang('name');
        $data['meta_description'] = $this->config->getValue('meta_description');
        if (!empty($data['read']->fieldLang('description'))) {
            $data['meta_description'] = Str::limit(strip_tags($data['read']->fieldLang('description')), 155);
        }

        //images
        $data['creator'] = $data['read']->createBy->name;
        $data['cover'] = $data['read']->imgPreview($data['read']->id);
        $data['banner'] = $data['read']->bannerSrc($data['read']);

        $blade = 'detail';
        if (!empty($data['read']->custom_view_id)) {
            $blade = config('custom.templates.path.albums.custom').'.'.
                collect(explode("/", $data['read']->customView->file_path))->last();
        }

        return view('frontend.gallery.albums.'.$blade, compact('data'), [
            'title' => $data['read']->fieldLang('name'),
            'breadcrumbs' => [
                __('common.gallery_caption') => route('gallery.list'),
                __('common.photo_caption') => route('gallery.photo'),
                Str::limit($data['read']->category->fieldLang('name'), 15) => route('gallery.photo.category', ['slugCategory' => $data['read']->category->slug]),
                Str::limit($data['read']->fieldLang('name'), 15) => ''
            ],
        ]);
    }

    /**
     * playlist
     */
    public function listCatPlaylist(Request $request)
    {
        $url = $request->url();
        $param = Str::replace($url, '', $request->fullUrl());
        $data['banner'] = $this->config->getFile('banner_default');
        $limit = $this->config->getValue('content_limit');

        $data['categories'] = $this->serviceCatPlaylist->getPlaylistCategory(null, true, $limit);
        $data['playlists'] = $this->servicePlaylist->getPlaylist($request, true, $limit);
        $data['videos'] = $this->serviceVideo->getVideo($request, true, $limit);

        return view('frontend.gallery.playlists.list', compact('data'), [
            'title' => __('common.gallery_caption').' '.__('common.video_caption'),
            'breadcrumbs' => [
                __('common.gallery_caption') => route('gallery.list'),
                __('common.video_caption') => ''
            ],
        ]);
    }

    public function readCatPlaylist(Request $request)
    {
        $slug = $request->route('slugCategory');

        $data['read'] = $this->serviceCatPlaylist->findBySlug($slug);

        //check
        if (empty($slug)) {
            return abort(404);
        }

        if ($data['read']->publish == 0 || empty($data['read'])) {
            return redirect()->route('home');
        }

        $limit = $this->config->getValue('content_limit');

        $data['playlists'] = $this->servicePlaylist->getPlaylist($request, true, $limit, $data['read']->id);
        $data['videos'] = $this->serviceVideo->getVideo($request, true, $data['read']->id, null);

        // meta data
        $data['meta_title'] = $data['read']->fieldLang('name');
        $data['meta_description'] = $this->config->getValue('meta_description');
        if (!empty($data['read']->fieldLang('description'))) {
            $data['meta_description'] = Str::limit(strip_tags($data['read']->fieldLang('description')), 155);
        }

        //images
        $data['creator'] = $data['read']->createBy->name;
        $data['cover'] = $data['read']->imgPreview();
        $data['banner'] = $this->config->getFile('banner_default');

        return view('frontend.gallery.playlists.category', compact('data'), [
            'title' => $data['read']->fieldLang('name'),
            'breadcrumbs' => [
                __('common.gallery_caption') => route('gallery.list'),
                __('common.gallery_video') => route('gallery.video'),
                Str::limit($data['read']->fieldLang('name'), 15) => ''
            ],
        ]);
    }

    public function readPlaylist(Request $request)
    {
        $slug = $request->route('slugPlaylist');

        $data['read'] = $this->servicePlaylist->findBySlug($slug);

        //check
        if (empty($slug)) {
            return abort(404);
        }

        if ($data['read']->publish == 0 || empty($data['read']) || $data['read']->is_detail == 0) {
            return redirect()->route('home');
        }

        //data
        $limit = $this->config->getValue('content_limit');
        if (!empty($data['read']->video_limit)) {
            $limit = $data['read']->video_limit;
        }
        $data['video'] = $this->serviceVideo->getVideo($request, false, null, null, $data['read']->id);

        // meta data
        $data['meta_title'] = $data['read']->fieldLang('name');
        $data['meta_description'] = $this->config->getValue('meta_description');
        if (!empty($data['read']->fieldLang('description'))) {
            $data['meta_description'] = Str::limit(strip_tags($data['read']->fieldLang('description')), 155);
        }

        //images
        $data['creator'] = $data['read']->createBy->name;
        $data['cover'] = $data['read']->imgPreview($data['read']->id);
        $data['banner'] = $data['read']->bannerSrc($data['read']);

        $blade = 'detail';
        if (!empty($data['read']->custom_view_id)) {
            $blade = config('custom.templates.path.playlists.custom').'.'.
                collect(explode("/", $data['read']->customView->file_path))->last();
        }

        return view('frontend.gallery.playlists.'.$blade, compact('data'), [
            'title' => $data['read']->fieldLang('name'),
            'breadcrumbs' => [
                __('common.gallery_caption') => route('gallery.list'),
                __('common.video_caption') => route('gallery.video'),
                Str::limit($data['read']->category->fieldLang('name'), 15) => route('gallery.video.category', ['slugCategory' => $data['read']->category->slug]),
                Str::limit($data['read']->fieldLang('name'), 15) => ''
            ],
        ]);
    }
}
