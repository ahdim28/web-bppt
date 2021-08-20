<?php

namespace App\Http\Controllers\Admin\Gallery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gallery\PhotoRequest;
use App\Services\Gallery\AlbumService;
use App\Services\Gallery\PhotoService;
use App\Services\LanguageService;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    private $service, $serviceAlbum, $serviceLang;

    public function __construct(
        PhotoService $service,
        AlbumService $serviceAlbum,
        LanguageService $serviceLang
    )
    {
        $this->service = $service;
        $this->serviceAlbum = $serviceAlbum;
        $this->serviceLang = $serviceLang;

        $this->lang = config('custom.language.multiple');
    }

    public function index(Request $request, $albumId)
    {
        $url = $request->url();
        $param = str_replace($url, '', $request->fullUrl());

        $data['photos'] = $this->service->getPhotoList($request, $albumId);
        $data['no'] = $data['photos']->firstItem();
        $data['photos']->withPath(url()->current().$param);
        $data['album'] = $this->serviceAlbum->find($albumId);

        return view('backend.gallery.albums.photo.index', compact('data'), [
            'title' => 'Album Photo',
            'routeBack' => route('gallery.album.index'),
            'breadcrumbs' => [
                'Gallery' => 'javascript:;',
                'Album' => route('gallery.album.index'),
                'Photo' => ''
            ]
        ]);
    }

    public function create($albumId)
    {
        $data['album'] = $this->serviceAlbum->find($albumId);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);

        return view('backend.gallery.albums.photo.form', compact('data'), [
            'title' => 'Add New Photo',
            'routeBack' => route('gallery.album.photo.index', ['albumId' => $albumId]),
            'breadcrumbs' => [
                'Gallery' => 'javascript:;',
                'Photo' => route('gallery.album.photo.index', ['albumId' => $albumId]),
                'Add' => ''
            ]
        ]);
    }

    public function store(PhotoRequest $request, $albumId)
    {
        $this->service->store($request, $albumId);

        $redir = $this->redirectForm($request, $albumId);
        return $redir->with('success', 'photo successfully added');
    }

    public function edit($albumId, $id)
    {
        $data['photo'] = $this->service->find($id);
        $data['album'] = $this->serviceAlbum->find($albumId);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);

        return view('backend.gallery.albums.photo.form-edit', compact('data'), [
            'title' => 'Edit Photo',
            'routeBack' => route('gallery.album.photo.index', ['albumId' => $albumId]),
            'breadcrumbs' => [
                'Gallery' => 'javascript:;',
                'Photo' => route('gallery.album.photo.index', ['albumId' => $albumId]),
                'Edit' => ''
            ]
        ]);
    }

    public function update(PhotoRequest $request, $albumId, $id)
    {
        $this->service->update($request, $id);

        $redir = $this->redirectForm($request, $albumId);
        return $redir->with('success', 'photo successfully updated');
    }

    public function publish($albumId, $id)
    {
        $this->service->publish($id);

        return back()->with('success', 'photo update successfully');
    }

    public function position($albumId, $id, $position)
    {
        $this->service->position($id, $position);

        return back()->with('success', 'position photo changed');
    }

    public function sort($albumId)
    {
        $i = 0;

        foreach ($_POST['datas'] as $value) {
            $i++;
            $this->service->sort($value, $i);
        }
    }

    public function destroy($albumId, $id)
    {
        $this->service->delete($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }

    public function redirectForm($request, $albumId)
    {
        $redir = redirect()->route('gallery.album.photo.index', ['albumId' => $albumId]);
        if ($request->action == 'back') {
            $redir = back();
        }

        return $redir;
    }
}
