<?php

namespace App\Http\Controllers\Admin\Gallery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gallery\AlbumCategoryRequest;
use App\Services\Gallery\AlbumCategoryService;
use App\Services\LanguageService;
use Illuminate\Http\Request;

class AlbumCategoryController extends Controller
{
    private $service, $serviceLang;

    public function __construct(
        AlbumCategoryService $service,
        LanguageService $serviceLang
    )
    {
        $this->service = $service;
        $this->serviceLang = $serviceLang;

        $this->lang = config('custom.language.multiple');
    }

    public function index(Request $request)
    {
        $url = $request->url();
        $param = str_replace($url, '', $request->fullUrl());

        $data['categories'] = $this->service->getAlbumCategoryList($request);
        $data['no'] = $data['categories']->firstItem();
        $data['categories']->withPath(url()->current().$param);

        return view('backend.gallery.albums.category.index', compact('data'), [
            'title' => 'Category Albums',
            'routeBack' => route('gallery.album.index'),
            'breadcrumbs' => [
                'Gallery' => 'javascript:;',
                'Albums' => route('gallery.album.index'),
                'Category' => ''
            ]
        ]);
    }

    public function create()
    {
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);

        return view('backend.gallery.albums.category.form', compact('data'), [
            'title' => 'Add New Category',
            'routeBack' => route('gallery.album.category.index'),
            'breadcrumbs' => [
                'Gallery' => 'javascript:;',
                'Albums' => route('gallery.album.index'),
                'Category' => route('gallery.album.category.index'),
                'Add' => '',
            ],
        ]);
    }

    public function store(AlbumCategoryRequest $request)
    {
        $this->service->store($request);

        $redir = $this->redirectForm($request);
        return $redir->with('success', 'category created successfully');
    }

    public function edit($id)
    {
        $data['category'] = $this->service->find($id);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);

        return view('backend.gallery.albums.category.form', compact('data'), [
            'title' => 'Edit Category',
            'routeBack' => route('gallery.album.category.index'),
            'breadcrumbs' => [
                'Gallery' => 'javascript:;',
                'Album' => route('gallery.album.index'),
                'Category '=> route('gallery.album.category.index'),
                'Edit' => ''
            ],
        ]);
    }

    public function update(AlbumCategoryRequest $request, $id)
    {
        $this->service->update($request, $id);

        $redir = $this->redirectForm($request);
        return $redir->with('success', 'category update successfully');
    }

    public function position($id, $position)
    {
        $this->service->position($id, $position);

        return back()->with('success', 'category update successfully');
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
                'message' => 'Cannot delete category, Because this category still has album',
            ], 200);
        }
    }

    public function redirectForm($request)
    {
        $redir = redirect()->route('gallery.album.category.index');
        if ($request->action == 'back') {
            $redir = back();
        }

        return $redir;
    }
}
