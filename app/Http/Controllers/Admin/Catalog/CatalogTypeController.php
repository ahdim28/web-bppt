<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\CatalogTypeRequest;
use App\Services\Catalog\CatalogTypeService;
use App\Services\LanguageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CatalogTypeController extends Controller
{
    private $service, $serviceLang;

    public function __construct(
        CatalogTypeService $service,
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
        $param = Str::replace($url, '', $request->fullUrl());

        $data['types'] = $this->service->getCatalogTypeList($request);
        $data['no'] = $data['types']->firstItem();
        $data['types']->withPath(url()->current().$param);

        return view('backend.catalog.types.index', compact('data'), [
            'title' => 'Catalog Type',
            'breadcrumbs' => [
                'Catalog' => 'javascript:;',
                'Type' => '',
            ]
        ]);
    }

    public function create()
    {
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);

        return view('backend.catalog.types.form', compact('data'), [
            'title' => 'Add New Type',
            'routeBack' => route('catalog.type.index'),
            'breadcrumbs' => [
                'Catalog' => 'javascript:;',
                'Type' => route('catalog.type.index'),
                'Add' => '',
            ],
        ]);
    }

    public function store(CatalogTypeRequest $request)
    {
        $this->service->store($request);

        $redir = $this->redirectForm($request);
        return $redir->with('success', 'catalog type created successfully');
    }

    public function edit($id)
    {
        $data['type'] = $this->service->find($id);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);

        return view('backend.catalog.types.form', compact('data'), [
            'title' => 'Edit Type',
            'routeBack' => route('catalog.type.index'),
            'breadcrumbs' => [
                'Catalog' => 'javascript:;',
                'Type' => route('catalog.type.index'),
                'Edit' => ''
            ],
        ]);
    }

    public function update(CatalogTypeRequest $request, $id)
    {
        $this->service->update($request, $id);

        $redir = $this->redirectForm($request);
        return $redir->with('success', 'catalog type updated successfully');
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
                'message' => 'Cannot delete type, Because this type still has product',
            ], 200);
        }
    }

    public function redirectForm($request)
    {
        $redir = redirect()->route('catalog.type.index');
        if ($request->action == 'back') {
            $redir = back();
        }

        return $redir;
    }
}
