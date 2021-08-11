<?php

namespace App\Http\Controllers\Admin\Gallery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gallery\AlbumRequest;
use App\Services\Gallery\AlbumCategoryService;
use App\Services\Gallery\AlbumService;
use App\Services\LanguageService;
use App\Services\Master\Field\FieldCategoryService;
use App\Services\Master\TemplateService;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    private $service, $serviceCat, $serviceLang, $serviceTemplate, $serviceField;

    public function __construct(
        AlbumService $service,
        AlbumCategoryService $serviceCat,
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

        $data['albums'] = $this->service->getAlbumList($request);
        $data['no'] = $data['albums']->firstItem();
        $data['albums']->withPath(url()->current().$param);

        return view('backend.gallery.albums.index', compact('data'), [
            'title' => 'Gallery Albums',
            'breadcrumbs' => [
                'Gallery' => 'javascript:;',
                'Albums' => '',
            ]
        ]);
    }

    public function create()
    {
        $data['categories'] = $this->serviceCat->getAlbumCategory(null, false, false);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);
        $data['template'] = $this->serviceTemplate->getTemplate(6);
        $data['fields'] = $this->serviceField->getFieldCategory();

        return view('backend.gallery.albums.form', compact('data'), [
            'title' => 'Add New Album',
            'routeBack' => route('gallery.album.index'),
            'breadcrumbs' => [
                'Gallery' => 'javascript:;',
                'Album' => route('gallery.album.index'),
                'Add' => '',
            ],
        ]);
    }

    public function store(AlbumRequest $request)
    {
        $this->service->store($request);

        $redir = $this->redirectForm($request);
        return $redir->with('success', 'album created successfully');
    }

    public function edit($id)
    {
        $data['album'] = $this->service->find($id);
        $data['categories'] = $this->serviceCat->getAlbumCategory(null, false, false);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);
        $data['template'] = $this->serviceTemplate->getTemplate(6);
        $data['fields'] = $this->serviceField->getFieldCategory();

        return view('backend.gallery.albums.form-edit', compact('data'), [
            'title' => 'Edit Album',
            'routeBack' => route('gallery.album.index'),
            'breadcrumbs' => [
                'Gallery' => 'javascript:;',
                'Album' => route('gallery.album.index'),
                'Edit' => ''
            ],
        ]);
    }

    public function update(AlbumRequest $request, $id)
    {
        $this->service->update($request, $id);

        $redir = $this->redirectForm($request);
        return $redir->with('success', 'album update successfully');
    }

    public function publish($id)
    {
        $this->service->publish($id);

        return back()->with('success', 'album update successfully');
    }

    public function position($id, $position)
    {
        $this->service->position($id, $position);

        return back()->with('success', 'album update successfully');
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
                'message' => 'Cannot delete album, Because this album still has photo',
            ], 200);
        }
    }

    public function redirectForm($request)
    {
        $redir = redirect()->route('gallery.album.index');
        if ($request->action == 'back') {
            $redir = back();
        }

        return $redir;
    }
}
