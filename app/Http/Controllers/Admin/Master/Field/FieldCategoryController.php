<?php

namespace App\Http\Controllers\Admin\Master\Field;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Field\FieldCategoryRequest;
use App\Services\Master\Field\FieldCategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FieldCategoryController extends Controller
{
    private $service;

    public function __construct(
        FieldCategoryService $service
    )
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $url = $request->url();
        $param = Str::replace($url, '', $request->fullUrl());

        $data['categories'] = $this->service->getFieldCategoryList($request);
        $data['no'] = $data['categories']->firstItem();
        $data['categories']->withPath(url()->current().$param);

        return view('backend.master.fields.categories.index', compact('data'), [
            'title' => __('mod/master.field.category.title'),
            'breadcrumbs' => [
                __('mod/master.mod_title') => 'javascript:;',
                __('mod/master.field.category.title') => ''
            ]
        ]);
    }

    public function create()
    {
        return view('backend.master.fields.categories.form', [
            'title' => __('lang.add_attr_new', [
                'attribute' => __('mod/master.field.category.title')
            ]),
            'routeBack' => route('field.category'),
            'breadcrumbs' => [
                __('mod/master.mod_title') => 'javascript:;',
                __('mod/master.field.category.title') => route('field.category'),
                __('lang.add') => ''
            ]
        ]);
    }

    public function store(FieldCategoryRequest $request)
    {
        $this->service->store($request);

        $redir = $this->redirectForm($request);
        return $redir->with('success', __('alert.create_success', [
            'attribute' => __('mod/master.field.category.title')
        ]));
    }

    public function edit($id)
    {
        $data['category'] = $this->service->find($id);

        return view('backend.master.fields.categories.form', compact('data'), [
            'title' => __('lang.edit_attr', [
                'attribute' => __('mod/master.field.category.title')
            ]),
            'routeBack' => route('field.category'),
            'breadcrumbs' => [
                __('mod/master.mod_title') => 'javascript:;',
                __('mod/master.field.category.title') => route('field.category'),
                __('lang.edit') => ''
            ]
        ]);
    }

    public function update(FieldCategoryRequest $request, $id)
    {
        $this->service->update($request, $id);

        $redir = $this->redirectForm($request);
        return $redir->with('success', __('alert.update_success', [
            'attribute' => __('mod/master.field.category.title')
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
                    'attribute' => __('mod/master.field.category.title')
                ])
            ], 200);
        }
    }

    public function redirectForm($request)
    {
        $redir = redirect()->route('field.category');
        if ($request->action == 'back') {
            $redir = back();
        }

        return $redir;
    }
}
