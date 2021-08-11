<?php

namespace App\Http\Controllers\Admin\Gallery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gallery\PlaylistRequest;
use App\Services\Gallery\PlaylistCategoryService;
use App\Services\Gallery\PlaylistService;
use App\Services\LanguageService;
use App\Services\Master\Field\FieldCategoryService;
use App\Services\Master\TemplateService;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    private $service, $serviceCat, $serviceLang, $serviceTemplate, $serviceField;

    public function __construct(
        PlaylistService $service,
        PlaylistCategoryService $serviceCat,
        LanguageService $serviceLang,
        TemplateService $serviceTemplate,
        FieldCategoryService $serviceField
    )
    {
        $this->service = $service;
        $this->serviceCat = $serviceCat;
        $this->serviceLang = $serviceLang;
        $this->serviceTemplate = $serviceTemplate;
        $this->serviceField = $serviceField;

        $this->lang = config('custom.language.multiple');
    }

    public function index(Request $request)
    {
        $url = $request->url();
        $param = str_replace($url, '', $request->fullUrl());

        $data['playlists'] = $this->service->getPlaylistList($request);
        $data['no'] = $data['playlists']->firstItem();
        $data['playlists']->withPath(url()->current().$param);

        return view('backend.gallery.playlists.index', compact('data'), [
            'title' => 'Gallery Playlists',
            'breadcrumbs' => [
                'Gallery' => 'javascript:;',
                'Playlists' => '',
            ]
        ]);
    }

    public function create()
    {
        $data['categories'] = $this->serviceCat->getPlaylistCategory(null, false, false);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);
        $data['template'] = $this->serviceTemplate->getTemplate(7);
        $data['fields'] = $this->serviceField->getFieldCategory();

        return view('backend.gallery.playlists.form', compact('data'), [
            'title' => 'Add New Playlist',
            'routeBack' => route('gallery.playlist.index'),
            'breadcrumbs' => [
                'Gallery' => 'javascript:;',
                'Playlist' => route('gallery.playlist.index'),
                'Add' => '',
            ],
        ]);
    }

    public function store(PlaylistRequest $request)
    {
        $this->service->store($request);

        $redir = $this->redirectForm($request);
        return $redir->with('success', 'playlist successfully added');
    }

    public function edit($id)
    {
        $data['playlist'] = $this->service->find($id);
        $data['categories'] = $this->serviceCat->getPlaylistCategory(null, false, false);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);
        $data['template'] = $this->serviceTemplate->getTemplate(7);
        $data['fields'] = $this->serviceField->getFieldCategory();

        return view('backend.gallery.playlists.form-edit', compact('data'), [
            'title' => 'Edit Playlist',
            'routeBack' => route('gallery.playlist.index'),
            'breadcrumbs' => [
                'Gallery' => 'javascript:;',
                'Playlist' => route('gallery.playlist.index'),
                'Edit' => ''
            ],
        ]);
    }

    public function update(PlaylistRequest $request, $id)
    {
        $this->service->update($request, $id);

        $redir = $this->redirectForm($request);
        return $redir->with('success', 'playlist successfully updated');
    }

    public function publish($id)
    {
        $this->service->publish($id);

        return back()->with('success', 'status playlist changed');
    }

    public function position($id, $position)
    {
        $this->service->position($id, $position);

        return back()->with('success', 'position playlist changed');
    }

    public function sort()
    {
        $i = 0;

        foreach ($_POST['datas'] as $value) {
            $i++;
            $this->service->sort($value, $i);
        }
    }

    public function destroy($id)
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
                'message' => 'Cannot delete playlist, Because this playlist still has video',
            ], 200);
        }
    }

    public function redirectForm($request)
    {
        $redir = redirect()->route('gallery.playlist.index');
        if ($request->action == 'back') {
            $redir = back();
        }

        return $redir;
    }
}
