<?php

namespace App\Http\Controllers\Admin\Document;

use App\Http\Controllers\Controller;
use App\Http\Requests\Document\DocumentCategoryRequest;
use App\Services\Document\DocumentCategoryService;
use App\Services\LanguageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DocumentCategoryController extends Controller
{
    private $service, $serviceLang;

    public function __construct(
        DocumentCategoryService $service,
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

        $data['categories'] = $this->service->getCategoryList($request);
        $data['no'] = $data['categories']->firstItem();
        $data['categories']->withPath(url()->current().$param);

        return view('backend.documents.categories.index', compact('data'), [
            'title' => 'Document Categories',
            'breadcrumbs' => [
                'Document Categories' => '',
            ]
        ]);
    }

    public function create(Request $request)
    {
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);

        if (isset($request->parent)) {
            $data['parent'] = $this->service->find($request->parent);
        }

        return view('backend.documents.categories.form', compact('data'), [
            'title' => __('lang.add_attr_new', [
                'attribute' => 'Category'
            ]),
            'routeBack' => route('document.category.index'),
            'breadcrumbs' => [
                'Category' => route('document.category.index'),
                __('lang.add') => '',
            ],
        ]);
    }

    public function store(DocumentCategoryRequest $request)
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

        return view('backend.documents.categories.form-edit', compact('data'), [
            'title' => __('lang.edit_attr', [
                'attribute' => 'Category'
            ]),
            'routeBack' => route('document.category.index'),
            'breadcrumbs' => [
                'Category' => route('document.category.index'),
                __('lang.edit') => ''
            ],
        ]);
    }

    public function update(DocumentCategoryRequest $request, $id)
    {
        $this->service->update($request, $id);

        $redir = $this->redirectForm($request);
        return $redir->with('success', __('alert.update_success', [
            'attribute' => 'Category'
        ]));
    }

    public function position(Request $request, $id, $position)
    {
        $this->service->position($id, $position, $request->get('parent'));

        return back()->with('success', __('alert.update_success', [
            'attribute' => 'Category'
        ]));
    }

    public function publish($id)
    {
        $this->service->publish($id);

        return back()->with('success', __('alert.update_success', [
            'attribute' => 'Category'
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
        $redir = redirect()->route('document.category.index');
        if ($request->action == 'back') {
            $redir = back();
        }

        return $redir;
    }
}
