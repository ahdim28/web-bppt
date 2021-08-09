<?php

namespace App\Http\Controllers\Admin\Banner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banner\BannerMultipleRequest;
use App\Http\Requests\Banner\BannerRequest;
use App\Services\Banner\BannerCategoryService;
use App\Services\Banner\BannerService;
use App\Services\LanguageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    private $service, $serviceCategory, $serviceLang;

    public function __construct(
        BannerService $service,
        BannerCategoryService $serviceCategory,
        LanguageService $serviceLang
    )
    {
        $this->service = $service;
        $this->serviceCategory = $serviceCategory;
        $this->serviceLang = $serviceLang;

        $this->lang = config('custom.language.multiple');
    }

    public function index(Request $request, $categoryId)
    {
        $url = $request->url();
        $param = Str::replace($url, '', $request->fullUrl());

        $data['banners'] = $this->service->getBannerList($request, $categoryId);
        $data['no'] = $data['banners']->firstItem();
        $data['banners']->withPath(url()->current().$param);
        $data['category'] = $this->serviceCategory->find($categoryId);

        return view('backend.banners.index', compact('data'), [
            'title' => 'Banner',
            'routeBack' => route('banner.category.index'),
            'breadcrumbs' => [
                'Category' => route('banner.category.index'),
                'Banner' => '',
            ]
        ]);
    }

    public function create($categoryId)
    {
        $data['category'] = $this->serviceCategory->find($categoryId);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);

        return view('backend.banners.form', compact('data'), [
            'title' => __('lang.add_attr_new', [
                'attribute' => 'Banner'
            ]),
            'routeBack' => route('banner.index', ['categoryId' => $categoryId]),
            'breadcrumbs' => [
                'Category' => route('banner.category.index'),
                'Banner' => route('banner.index', ['categoryId' => $categoryId]),
                __('lang.add') => '',
            ],
        ]);
    }

    public function store(BannerRequest $request, $categoryId)
    {
        $this->service->store($request, $categoryId);

        $redir = $this->redirectForm($request, $categoryId);
        return $redir->with('success', __('alert.create_success', [
            'attribute' => 'Banner'
        ]));
    }

    public function storeMultiple(BannerMultipleRequest $request, $categoryId)
    {
        $this->service->storeMultiple($request, $categoryId);

        $redir = $this->redirectForm($request, $categoryId);
        return $redir->with('success', __('alert.create_success', [
            'attribute' => 'Banner'
        ]));
    }

    public function edit($categoryId, $id)
    {
        $data['banner'] = $this->service->find($id);
        $data['category'] = $this->serviceCategory->find($categoryId);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);

        return view('backend.banners.form-edit', compact('data'), [
            'title' => __('lang.edit_attr', [
                'attribute' => 'Banner'
            ]),
            'routeBack' => route('banner.index', ['categoryId' => $categoryId]),
            'breadcrumbs' => [
                'Category' => route('banner.category.index'),
                'Banner' => route('banner.index', ['categoryId' => $categoryId]),
                __('lang.edit') => ''
            ],
        ]);
    }

    public function update(BannerRequest $request, $categoryId, $id)
    {
        $this->service->update($request, $id);

        $redir = $this->redirectForm($request, $categoryId);
        return $redir->with('success', __('alert.update_success', [
            'attribute' => 'Banner'
        ]));
    }

    public function publish($categoryId, $id)
    {
        $this->service->publish($id);

        return back()->with('success', __('alert.update_success', [
            'attribute' => 'Banner'
        ]));
    }

    public function position($categoryId, $id, $position)
    {
        $this->service->position($id, $position);

        return back()->with('success', __('alert.update_success', [
            'attribute' => 'Banner'
        ]));
    }

    public function sort($categoryId)
    {
        $i = 0;

        foreach ($_POST['datas'] as $value) {
            $i++;
            $this->service->sort($value, $i);
        }
    }

    public function destroy($categoryId, $id)
    {
        $this->service->delete($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }

    public function redirectForm($request, $categoryId)
    {
        $redir = redirect()->route('banner.index', ['categoryId' => $categoryId]);
        if ($request->action == 'back') {
            $redir = back();
        }

        return $redir;
    }
}
