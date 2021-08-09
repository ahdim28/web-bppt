<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\MenuCategoryRequest;
use App\Services\Menu\MenuCategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuCategoryController extends Controller
{
    private $service;

    public function __construct(
        MenuCategoryService $service
    )
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $url = $request->url();
        $param = Str::replace($url, '', $request->fullUrl());

        $data['categories'] = $this->service->getMenuCategoryList($request);
        $data['no'] = $data['categories']->firstItem();
        $data['categories']->withPath(url()->current().$param);

        return view('backend.menu.categories.index', compact('data'), [
            'title' => __('mod/menu.category.title'),
            'breadcrumbs' => [
                __('mod/menu.title') => 'javascript:;',
                __('mod/menu.category.caption') => '',
            ]
        ]);
    }

    public function store(MenuCategoryRequest $request)
    {
        $this->service->store($request);

        return back()->with('success', __('alert.create_success', [
            'attribute' => __('mod/menu.category.title')
        ]));
    }

    public function update(MenuCategoryRequest $request, $id)
    {
        $this->service->update($request, $id);

        return back()->with('success', __('alert.update_success', [
            'attribute' => __('mod/menu.category.title')
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
                    'attribute' => __('mod/menu.category.title')
                ])
            ], 200);
        }
    }
}
