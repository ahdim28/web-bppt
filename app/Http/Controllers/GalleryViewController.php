<?php

namespace App\Http\Controllers;

use App\Services\ConfigurationService;
use App\Services\Gallery\AlbumService;
use App\Services\Gallery\PhotoService;
use App\Services\Gallery\PlaylistService;
use App\Services\Gallery\VideoService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryViewController extends Controller
{
    private $serviceAlbum, $servicePhoto, $servicePlaylist, $serviceVideo, $config;

    public function __construct(
        AlbumService $serviceAlbum,
        PhotoService $servicePhoto,
        PlaylistService $servicePlaylist,
        VideoService $serviceVideo,
        ConfigurationService $config
    )
    {
        $this->serviceAlbum = $serviceAlbum;
        $this->servicePhoto = $servicePhoto;
        $this->servicePlaylist = $servicePlaylist;
        $this->serviceVideo = $serviceVideo;
        $this->config = $config;
    }

    public function list(Request $request)
    {
        return redirect()->route('home');
        
        $data['banner'] = $this->config->getFile('banner_default');
        $limit = $this->config->getValue('content_limit');
        $data['album'] = $this->serviceAlbum->getAlbum($request, null, $limit);
        $data['playlist'] = $this->servicePlaylist->getPlaylist($request, null, $limit);

        return view('frontend.gallery.index', compact('data'), [
            'title' => 'Gallery',
            'breadcrumbs' => [
                'Gallery' => ''
            ],
        ]);
    }

    /**
     * album
     */
    public function listAlbum(Request $request)
    {
        $data['banner'] = $this->config->getFile('banner_default');
        $limit = $this->config->getValue('content_limit');
        $data['album'] = $this->serviceAlbum->getAlbum($request, 'paginate', $limit);
        $data['photo'] = $this->servicePhoto->getPhoto($request, 'paginate', $limit);

        return view('frontend.gallery.albums.list', compact('data'), [
            'title' => 'Gallery - Album',
            'breadcrumbs' => [
                'Gallery' => route('gallery.list'),
                'Album' => ''
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

        $this->serviceAlbum->recordViewer($data['read']->id);

        //data
        $limit = $this->config->getValue('content_limit');
        if (!empty($data['read']->photo_limit)) {
            $limit = $data['read']->photo_limit;
        }
        $data['photo'] = $this->servicePhoto->getPhoto($request, null, null, $data['read']->id);

        // meta data
        $data['meta_title'] = $data['read']->fieldLang('name');
        $data['meta_description'] = $this->config->getValue('meta_description');
        if (!empty($data['read']->fieldLang('description'))) {
            $data['meta_description'] = Str::limit(strip_tags($data['read']->fieldLang('description')), 155);
        }

        //images
        $data['creator'] = $data['read']->createBy->name;
        $data['cover'] = $data['read']->photoCover($data['read']->id);
        $data['banner'] = $data['read']->bannerSrc($data['read']);

        $blade = 'detail';
        if (!empty($data['read']->custom_view_id)) {
            $blade = config('custom.templates.path.albums.custom').'.'.
                collect(explode("/", $data['read']->customView->file_path))->last();
        }

        return view('frontend.gallery.albums.'.$blade, compact('data'), [
            'title' => $data['read']->fieldLang('name'),
            'breadcrumbs' => [
                $data['read']->fieldLang('name') => ''
            ],
        ]);
    }

    /**
     * playlist
     */
    public function listPlaylist(Request $request)
    {
        $data['banner'] = $this->config->getFile('banner_default');
        $limit = $this->config->getValue('content_limit');
        $data['playlist'] = $this->servicePlaylist->getPlaylist($request, 'paginate', $limit);
        $data['video'] = $this->serviceVideo->getVideo($request, 'paginate', $limit);

        return view('frontend.gallery.playlists.list', compact('data'), [
            'title' => 'Gallery - Playlists',
            'breadcrumbs' => [
                'Galeri' => route('gallery.list'),
                'Playlist' => ''
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

        $this->servicePlaylist->recordViewer($data['read']->id);

        //data
        $limit = $this->config->getValue('content_limit');
        if (!empty($data['read']->video_limit)) {
            $limit = $data['read']->video_limit;
        }
        $data['video'] = $this->serviceVideo->getVideo($request, null, null, $data['read']->id);

        // meta data
        $data['meta_title'] = $data['read']->fieldLang('name');
        $data['meta_description'] = $this->config->getValue('meta_description');
        if (!empty($data['read']->fieldLang('description'))) {
            $data['meta_description'] = Str::limit(strip_tags($data['read']->fieldLang('description')), 155);
        }

        //images
        $data['creator'] = $data['read']->createBy->name;
        $data['cover'] = $data['read']->coverSrc($data['read']->id);
        $data['banner'] = $data['read']->bannerSrc($data['read']);

        $blade = 'detail';
        if (!empty($data['read']->custom_view_id)) {
            $blade = config('custom.templates.path.playlists.custom').'.'.
                collect(explode("/", $data['read']->customView->file_path))->last();
        }

        return view('frontend.gallery.playlists.'.$blade, compact('data'), [
            'title' => $data['read']->fieldLang('name'),
            'breadcrumbs' => [
                $data['read']->fieldLang('name') => ''
            ],
        ]);
    }
}
