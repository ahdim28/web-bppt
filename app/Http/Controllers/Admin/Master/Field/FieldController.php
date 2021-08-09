<?php

namespace App\Http\Controllers\Admin\Master\Field;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Field\FieldRequest;
use App\Services\Master\Field\FieldCategoryService;
use App\Services\Master\Field\FieldService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FieldController extends Controller
{
    private $service, $serviceCategory;

    public function __construct(
        FieldService $service,
        FieldCategoryService $serviceCategory
    )
    {
        $this->service = $service;
        $this->serviceCategory = $serviceCategory;
    }

    public function index(Request $request, $categoryId)
    {
        $url = $request->url();
        $param = Str::replace($url, '', $request->fullUrl());

        $data['fields'] = $this->service->getFieldList($request, $categoryId);
        $data['no'] = $data['fields']->firstItem();
        $data['fields']->withPath(url()->current().$param);
        $data['category'] = $this->serviceCategory->find($categoryId);

        return view('backend.master.fields.index', compact('data'), [
            'title' =>  __('mod/master.field.title'),
            'routeBack' => route('field.category'),
            'breadcrumbs' => [
                __('mod/master.mod_title') => 'javascript:;',
                __('mod/master.field.category.title') => route('field.category'),
                __('mod/master.field.title') => ''
            ]
        ]);
    }

    public function apiData(Request $request)
    {
        $field = $this->serviceCategory->find($request->category_id);

        return response()->json([
            'field' => $field->fields
        ], 200);
    }

    public function create($categoryId)
    {
        $data['category'] = $this->serviceCategory->find($categoryId);

        return view('backend.master.fields.form', compact('data'), [
            'title' => __('lang.add_attr_new', [
                'attribute' => __('mod/master.field.caption')
            ]),
            'routeBack' => route('field.index', ['categoryId' => $categoryId]),
            'breadcrumbs' => [
                __('mod/master.mod_title') => 'javascript:;',
                __('mod/master.field.category.title') => route('field.category'),
                __('mod/master.field.title') => route('field.index', ['categoryId' => $categoryId]),
                __('lang.add') => ''
            ]
        ]);
    }

    public function store(FieldRequest $request, $categoryId)
    {
        $this->service->store($request, $categoryId);

        $redir = $this->redirectForm($request, $categoryId);
        return $redir->with('success', __('alert.create_success', [
            'attribute' => __('mod/master.field.caption')
        ]));
    }

    public function edit($categoryId, $id)
    {
        $data['field'] = $this->service->find($id);
        $data['category'] = $this->serviceCategory->find($categoryId);

        return view('backend.master.fields.form', compact('data'), [
            'title' => __('lang.edit_attr', [
                'attribute' => __('mod/master.field.caption')
            ]),
            'routeBack' => route('field.index', ['categoryId' => $categoryId]),
            'breadcrumbs' => [
                __('mod/master.mod_title') => 'javascript:;',
                __('mod/master.field.category.title') => route('field.category'),
                __('mod/master.field.title') => route('field.index', ['categoryId' => $categoryId]),
                __('lang.edit') => ''
            ]
        ]);
    }

    public function update(FieldRequest $request, $categoryId, $id)
    {
        $this->service->update($request, $id);

        $redir = $this->redirectForm($request, $categoryId);
        return $redir->with('success', __('alert.update_success', [
            'attribute' => __('mod/master.field.caption')
        ]));
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
        $redir = redirect()->route('field.index', ['categoryId' => $categoryId]);
        if ($request->action == 'back') {
            $redir = back();
        }

        return $redir;
    }
}
