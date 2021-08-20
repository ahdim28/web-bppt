<?php

namespace App\Http\Controllers\Admin\Document;

use App\Http\Controllers\Controller;
use App\Http\Requests\Document\DocumentRequest;
use App\Services\Document\DocumentCategoryService;
use App\Services\Document\DocumentService;
use App\Services\LanguageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    private $service, $serviceCategory, $serviceLang;

    public function __construct(
        DocumentService $service,
        DocumentCategoryService $serviceCategory,
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

        $data['documents'] = $this->service->getDocumentList($request, $categoryId);
        $data['no'] = $data['documents']->firstItem();
        $data['documents']->withPath(url()->current().$param);
        $data['category'] = $this->serviceCategory->find($categoryId);

        return view('backend.documents.index', compact('data'), [
            'title' => 'Category - Document',
            'routeBack' => route('document.category.index'),
            'breadcrumbs' => [
                'Category' => route('document.category.index'),
                'Document' => '',
            ]
        ]);
    }

    public function create(Request $request, $categoryId)
    {
        $data['category'] = $this->serviceCategory->find($categoryId);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);

        return view('backend.documents.form', compact('data'), [
            'title' => __('lang.add_attr_new', [
                'attribute' => 'Document'
            ]),
            'routeBack' => route('document.index', ['categoryId' => $categoryId]),
            'breadcrumbs' => [
                'Category' => route('document.category.index'),
                'Document' => route('document.index', ['categoryId' => $categoryId]),
                __('lang.add') => '',
            ],
        ]);
    }

    public function store(DocumentRequest $request, $categoryId)
    {
        $this->service->store($request, $categoryId);

        $redir = $this->redirectForm($request, $categoryId);
        return $redir->with('success', __('alert.create_success', [
            'attribute' => 'Document'
        ]));
    }

    public function edit($categoryId, $id)
    {
        $data['category'] = $this->serviceCategory->find($categoryId);
        $data['document'] = $this->service->find($id);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);

        return view('backend.documents.form-edit', compact('data'), [
            'title' => __('lang.edit_attr', [
                'attribute' => 'Category'
            ]),
            'routeBack' => route('document.index', ['categoryId' => $categoryId]),
            'breadcrumbs' => [
                'Category' => route('document.category.index'),
                'Document' => route('document.index', ['categoryId' => $categoryId]),
                __('lang.edit') => ''
            ],
        ]);
    }

    public function update(DocumentRequest $request, $categoryId, $id)
    {
        $this->service->update($request, $id);

        $redir = $this->redirectForm($request, $categoryId);
        return $redir->with('success', __('alert.update_success', [
            'attribute' => 'Document'
        ]));
    }

    public function position(Request $request, $categoryId, $id, $position)
    {
        $this->service->position($id, $position);

        return back()->with('success', __('alert.update_success', [
            'attribute' => 'Document'
        ]));
    }

    public function publish($categoryId, $id)
    {
        $this->service->publish($id);

        return back()->with('success', __('alert.update_success', [
            'attribute' => 'Document'
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
                    'attribute' => 'Document'
                ])
            ], 200);
        }
    }

    public function redirectForm($request, $categoryId)
    {
        $redir = redirect()->route('document.index', ['categoryId' => $categoryId]);
        if ($request->action == 'back') {
            $redir = back();
        }

        return $redir;
    }
}
