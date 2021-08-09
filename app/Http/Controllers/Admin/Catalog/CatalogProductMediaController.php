<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\CatalogProductMediaMultipleRequest;
use App\Http\Requests\Catalog\CatalogProductMediaRequest;
use App\Services\Catalog\Product\CatalogProductMediaService;
use App\Services\Catalog\Product\CatalogProductService;
use Illuminate\Http\Request;

class CatalogProductMediaController extends Controller
{
    private $service, $serviceProduct;

    public function __construct(
        CatalogProductMediaService $service,
        CatalogProductService $serviceProduct
    )
    {
        $this->service = $service;
        $this->serviceProduct = $serviceProduct;
    }

    public function index(Request $request, $productId)
    {
        $url = $request->url();
        $param = str_replace($url, '', $request->fullUrl());

        $data['medias'] = $this->service->getMediaList($request, $productId);
        $data['no'] = $data['medias']->firstItem();
        $data['medias']->withPath(url()->current().$param);
        $data['product'] = $this->serviceProduct->find($productId);

        return view('backend.catalog.products.medias.index', compact('data'), [
            'title' => 'Media Product',
            'routeBack' => route('catalog.product.index'),
            'breadcrumbs' => [
                'Catalog' => 'javascript:;',
                'Products' => route('catalog.product.index'),
                'Media' => ''
            ]
        ]);
    }

    public function create($productId)
    {
        $data['product'] = $this->serviceProduct->find($productId);

        return view('backend.catalog.products.medias.form', compact('data'), [
            'title' => 'Add New Media',
            'routeBack' => route('catalog.product.media.index', ['productId' => $productId]),
            'breadcrumbs' => [
                'Catalog' => 'javascript:;',
                'Product' => route('catalog.product.index'),
                'Media' => route('catalog.product.media.index', ['productId' => $productId]),
                'Add' => '',
            ],
        ]);
    }

    public function store(CatalogProductMediaRequest $request, $productId)
    {
        $this->service->store($request, $productId);

        $redir = $this->redirectForm($request, $productId);
        return $redir->with('success', 'media created successfully');
    }

    public function storeMultiple(CatalogProductMediaMultipleRequest $request, $productId)
    {
        $this->service->storeMultiple($request, $productId);

        $redir = $this->redirectForm($request, $productId);
        return $redir->with('success', 'media created successfully');
    }

    public function edit($productId, $id)
    {
        $data['media'] = $this->service->find($id);
        $data['product'] = $this->serviceProduct->find($productId);

        return view('backend.catalog.products.medias.form-edit', compact('data'), [
            'title' => 'Edit Media',
            'routeBack' => route('catalog.product.media.index', ['productId' => $productId]),
            'breadcrumbs' => [
                'Catalog' => 'javascript:;',
                'Product' => route('catalog.product.index'),
                'Media' => route('catalog.product.media.index', ['productId' => $productId]),
                'Edit' => '',
            ],
        ]);
    }

    public function update(CatalogProductMediaRequest $request, $productId, $id)
    {
        $this->service->update($request, $id);

        $redir = $this->redirectForm($request, $productId);
        return $redir->with('success', 'media updated successfully');
    }

    public function position($productId, $id, $position)
    {
        $this->service->position($id, $position);

        return back()->with('success', 'media updated successfully');
    }

    public function sort($productId)
    {
        $i = 0;

        foreach ($_POST['datas'] as $value) {
            $i++;
            $this->service->sort($value, $i);
        }
    }

    public function destroy($productId, $id)
    {
        $this->service->delete($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }

    public function redirectForm($request, $productId)
    {
        $redir = redirect()->route('catalog.product.media.index', ['productId' => $productId]);
        if ($request->action == 'back') {
            $redir = back();
        }

        return $redir;
    }
}
