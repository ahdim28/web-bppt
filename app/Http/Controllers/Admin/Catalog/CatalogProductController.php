<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\CatalogProductRequest;
use App\Services\Catalog\CatalogCategoryService;
use App\Services\Catalog\CatalogTypeService;
use App\Services\Catalog\Product\CatalogProductService;
use App\Services\LanguageService;
use App\Services\Master\Field\FieldCategoryService;
use App\Services\Master\TagService;
use App\Services\Master\TemplateService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CatalogProductController extends Controller
{
    private $service, $serviceType, $serviceCategory, $serviceLang, 
        $serviceTemplate, $serviceTag, $serviceField;

    public function __construct(
        CatalogProductService $service,
        CatalogTypeService $serviceType,
        CatalogCategoryService $serviceCategory,
        LanguageService $serviceLang,
        TemplateService $serviceTemplate,
        TagService $serviceTag,
        FieldCategoryService $serviceField
    )
    {
        $this->service = $service;
        $this->serviceType = $serviceType;
        $this->serviceCategory = $serviceCategory;
        $this->serviceLang = $serviceLang;
        $this->serviceTemplate = $serviceTemplate;
        $this->serviceTag = $serviceTag;
        $this->serviceField = $serviceField;

        $this->lang = config('custom.language.multiple');
    }

    public function index(Request $request)
    {
        $url = $request->url();
        $param = Str::replace($url, '', $request->fullUrl());

        $data['products'] = $this->service->getCatalogProductList($request);
        $data['no'] = $data['products']->firstItem();
        $data['products']->withPath(url()->current().$param);
        $data['types'] = $this->serviceType->getCatalogType();
        $data['categories'] = $this->serviceCategory->getCatalogCategory();

        return view('backend.catalog.products.index', compact('data'), [
            'title' => 'Catalog Products',
            'breadcrumbs' => [
                'Catalog' => 'javascript:;',
                'Products' => '',
            ]
        ]);
    }

    public function create(Request $request)
    {
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);
        $data['types'] = $this->serviceType->getCatalogType();
        $data['categories'] = $this->serviceCategory->getCatalogCategory();
        $data['template'] = $this->serviceTemplate->getTemplate(5);
        $data['fields'] = $this->serviceField->getFieldCategory();

        return view('backend.catalog.products.form', compact('data'), [
            'title' => 'Add New Product',
            'routeBack' => route('catalog.product.index'),
            'breadcrumbs' => [
                'Catalog' => 'javascript:;',
                'Product' => route('catalog.product.index'),
                'Create' => '',
            ],
        ]);
    }

    public function store(CatalogProductRequest $request)
    {
        $this->service->store($request);

        $redir = $this->redirectForm($request);
        return $redir->with('success', 'product created successfully');
    }

    public function edit($id)
    {
        $data['product'] = $this->service->find($id);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);
        $data['types'] = $this->serviceType->getCatalogType();
        $data['categories'] = $this->serviceCategory->getCatalogCategory();
        $data['template'] = $this->serviceTemplate->getTemplate(5);
        $data['fields'] = $this->serviceField->getFieldCategory();

        $tag = [];
        foreach ($data['product']->tags as $key => $value) {
            $tag[$key] = $value->tag->name;
        }

        $data['tags'] = implode(',', $tag);

        return view('backend.catalog.products.form-edit', compact('data'), [
            'title' => 'Edit Product',
            'routeBack' => route('catalog.product.index'),
            'breadcrumbs' => [
                'Catalog' => 'javascript:;',
                'Products' => route('catalog.product.index'),
                'Edit' => ''
            ],
        ]);
    }

    public function update(CatalogProductRequest $request, $id)
    {
        $this->service->update($request, $id);

        $redir = $this->redirectForm($request);
        return $redir->with('success', 'product updated successfully');
    }

    public function publish($id)
    {
        $this->service->publish($id);

        return back()->with('success', 'product updated successfully');
    }

    public function selection($id)
    {
        $product = $this->service->find($id);
        $check = $this->service->selection($id);

        if ($check == true) {
            return back()->with('success', 'product updated successfully');
        } else {
            return back()->with('warning', 'Cannot select product because 
                product select limited '.$product->category->product_selection);
        }
    }

    public function position($id, $position)
    {
        $this->service->position($id, $position);

        return back()->with('success', 'product updated successfully');
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
                'message' => __('alert.delete_failed_used', [
                    'attribute' => 'Product'
                ])
            ], 200);
        }
    }

    public function redirectForm($request)
    {
        $redir = redirect()->route('catalog.product.index');
        if ($request->action == 'back') {
            $redir = back();
        }

        return $redir;
    }
}
