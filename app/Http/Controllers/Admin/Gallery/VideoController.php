<?php

namespace App\Http\Controllers\Admin\Gallery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gallery\VideoRequest;
use App\Services\Gallery\PlaylistService;
use App\Services\Gallery\VideoService;
use App\Services\LanguageService;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    private $service, $servicePlaylist, $serviceLang;

    public function __construct(
        VideoService $service,
        PlaylistService $servicePlaylist,
        LanguageService $serviceLang
    )
    {
        $this->service = $service;
        $this->servicePlaylist = $servicePlaylist;
        $this->serviceLang = $serviceLang;

        $this->lang = config('custom.language.multiple');
    }

    public function index(Request $request, $playlistId)
    {
        $url = $request->url();
        $param = str_replace($url, '', $request->fullUrl());

        $data['videos'] = $this->service->getVideoList($request, $playlistId);
        $data['no'] = $data['videos']->firstItem();
        $data['videos']->withPath(url()->current().$param);
        $data['playlist'] = $this->servicePlaylist->find($playlistId);

        return view('backend.gallery.playlists.video.index', compact('data'), [
            'title' => 'Playlist Video',
            'routeBack' => route('gallery.playlist.index'),
            'breadcrumbs' => [
                'Gallery' => 'javascript:;',
                'Playlist' => route('gallery.playlist.index'),
                'Video' => ''
            ]
        ]);
    }

    public function create($playlistId)
    {
        $data['playlist'] = $this->servicePlaylist->find($playlistId);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);

        return view('backend.gallery.playlists.video.form', compact('data'), [
            'title' => 'Add New Video',
            'routeBack' => route('gallery.playlist.video.index', ['playlistId' => $playlistId]),
            'breadcrumbs' => [
                'Gallery' => 'javascript:;',
                'Video' => route('gallery.playlist.video.index', ['playlistId' => $playlistId]),
                'Add' => ''
            ]
        ]);
    }

    public function store(VideoRequest $request, $playlistId)
    {
        $this->service->store($request, $playlistId);

        $redir = $this->redirectForm($request, $playlistId);
        return $redir->with('success', 'video successfully added');
    }

    public function edit($playlistId, $id)
    {
        $data['video'] = $this->service->find($id);
        $data['playlist'] = $this->servicePlaylist->find($playlistId);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);

        return view('backend.gallery.playlists.video.form-edit', compact('data'), [
            'title' => 'Edit Video',
            'routeBack' => route('gallery.playlist.video.index', ['playlistId' => $playlistId]),
            'breadcrumbs' => [
                'Gallery' => 'javascript:;',
                'Video' => route('gallery.playlist.video.index', ['playlistId' => $playlistId]),
                'Edit' => ''
            ]
        ]);
    }

    public function update(VideoRequest $request, $playlistId, $id)
    {
        $this->service->update($request, $id);

        $redir = $this->redirectForm($request, $playlistId);
        return $redir->with('success', 'video successfully updated');
    }

    public function position($playlistId, $id, $position)
    {
        $this->service->position($id, $position);

        return back()->with('success', 'position video changed');
    }

    public function sort($playlistId)
    {
        $i = 0;

        foreach ($_POST['datas'] as $value) {
            $i++;
            $this->service->sort($value, $i);
        }
    }

    public function destroy($playlistId, $id)
    {
        $this->service->delete($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }

    public function redirectForm($request, $playlistId)
    {
        $redir = redirect()->route('gallery.playlist.video.index', ['playlistId' => $playlistId]);
        if ($request->action == 'back') {
            $redir = back();
        }

        return $redir;
    }
}
