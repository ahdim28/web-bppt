<?php

namespace App\Http\Controllers\Admin\Banner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banner\BannerCategoryRequest;
use App\Services\Banner\BannerCategoryService;
use App\Services\LanguageService;
use App\Services\Master\Field\FieldCategoryService;
use App\Services\Master\TemplateService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BannerCategoryController extends Controller
{
    private $service, $serviceLang, $serviceTemplate, $serviceField;

    public function __construct(
        BannerCategoryService $service,
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
        $param = str_replace($url, '', $request->fullUrl());

        $data['categories'] = $this->service->getBannerCategoryList($request);
        $data['no'] = $data['categories']->firstItem();
        $data['categories']->withPath(url()->current().$param);

        return view('backend.banners.categories.index', compact('data'), [
            'title' => 'Banner Categories',
            'breadcrumbs' => [
                'Banner' => 'javascript:;',
                'Categories' => '',
            ]
        ]);
    }

    public function create()
    {
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);
        $data['fields'] = $this->serviceField->getFieldCategory();

        return view('backend.banners.categories.form', compact('data'), [
            'title' => __('lang.add_attr_new', [
                'attribute' => 'Category'
            ]),
            'routeBack' => route('banner.category.index'),
            'breadcrumbs' => [
                'Banner' => 'javascript:;',
                'Category' => route('banner.category.index'),
                __('lang.add') => '',
            ],
        ]);
    }

    public function store(BannerCategoryRequest $request)
    {
        $this->service->store($request);

        $redir = $this->redirectForm($request);
        return $redir->with('success', __('alert.create_success', [
            'attribute' => 'Category'
        ]));
    }

    public function edit($id)
    {
        $data['category'] = $this->service->find($id);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);
        $data['fields'] = $this->serviceField->getFieldCategory();

        return view('backend.banners.categories.form-edit', compact('data'), [
            'title' => __('lang.edit_attr', [
                'attribute' => 'Category'
            ]),
            'routeBack' => route('banner.category.index'),
            'breadcrumbs' => [
                'Banner' => 'javascript:;',
                'Category' => route('banner.category.index'),
                __('lang.edit') => ''
            ],
        ]);
    }

    public function update(BannerCategoryRequest $request, $id)
    {
        $this->service->update($request, $id);

        $redir = $this->redirectForm($request);
        return $redir->with('success', __('alert.update_success', [
            'attribute' =>'Category'
        ]));
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
                    'attribute' => 'Category'
                ])
            ], 200);
        }
    }

    public function redirectForm($request)
    {
        $redir = redirect()->route('banner.category.index');
        if ($request->action == 'back') {
            $redir = back();
        }

        return $redir;
    }
}
