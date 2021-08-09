<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\CatalogCategoryRequest;
use App\Services\Catalog\CatalogCategoryService;
use App\Services\LanguageService;
use App\Services\Master\Field\FieldCategoryService;
use App\Services\Master\TemplateService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CatalogCategoryController extends Controller
{
    private $service, $serviceLang, $serviceTemplate, $serviceField;

    public function __construct(
        CatalogCategoryService $service,
        LanguageService $serviceLang,
        TemplateService $serviceTemplate,
        FieldCategoryService $serviceField
    )
    {
        $this->service = $service;
        $this->serviceLang = $serviceLang;
        $this->serviceTemplate = $serviceTemplate;
        $this->serviceField = $serviceField;

        $this->lang = config('custom.language.multiple');
    }

    public function index(Request $request)
    {
        $url = $request->url();
        $param = Str::replace($url, '', $request->fullUrl());

        $data['categories'] = $this->service->getCatalogCategoryList($request);
        $data['no'] = $data['categories']->firstItem();
        $data['categories']->withPath(url()->current().$param);

        return view('backend.catalog.categories.index', compact('data'), [
            'title' => 'Catalog Category',
            'breadcrumbs' => [
                'Catalog' => 'javascript:;',
                'Category' => '',
            ]
        ]);
    }

    public function create(Request $request)
    {
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);
        $data['template'] = $this->serviceTemplate->getTemplate(4);
        $data['fields'] = $this->serviceField->getFieldCategory();

        return view('backend.catalog.categories.form', compact('data'), [
            'title' => 'Add New Category',
            'routeBack' => route('catalog.category.index'),
            'breadcrumbs' => [
                'Catalog' => 'javascript:;',
                'Category' => route('catalog.category.index'),
                'Add' => '',
            ],
        ]);
    }

    public function store(CatalogCategoryRequest $request)
    {
        $this->service->store($request);

        $redir = $this->redirectForm($request);
        return $redir->with('success', 'catalog category created successfully');
    }

    public function edit($id)
    {
        $data['category'] = $this->service->find($id);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);
        $data['template'] = $this->serviceTemplate->getTemplate(4);
        $data['fields'] = $this->serviceField->getFieldCategory();

        return view('backend.catalog.categories.form-edit', compact('data'), [
            'title' => 'Edit Category',
            'routeBack' => route('catalog.category.index'),
            'breadcrumbs' => [
                'Catalog' => 'javascript:;',
                'Category' => route('catalog.category.index'),
                'Edit' => ''
            ],
        ]);
    }

    public function update(CatalogCategoryRequest $request, $id)
    {
        $this->service->update($request, $id);

        $redir = $this->redirectForm($request);
        return $redir->with('success', 'catalog category updated successfully');
    }

    public function position($id, $position)
    {
        $this->service->position($id, $position);

        return back()->with('success', 'catalog category updated successfully');
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
                'message' => 'Cannot delete catalog category, Because this category still has product',
            ], 200);
        }
    }

    public function redirectForm($request)
    {
        $redir = redirect()->route('catalog.category.index');
        if ($request->action == 'back') {
            $redir = back();
        }

        return $redir;
    }
}
