<?php

namespace App\Http\Controllers\Admin\Page;

use App\Http\Controllers\Controller;
use App\Http\Requests\Page\PageRequest;
use App\Services\LanguageService;
use App\Services\Master\Field\FieldCategoryService;
use App\Services\Master\TemplateService;
use App\Services\Page\PageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    private $service, $serviceLang, $serviceTemplate, $serviceField;

    public function __construct(
        PageService $service,
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

        $data['pages'] = $this->service->getPageList($request);
        $data['no'] = $data['pages']->firstItem();
        $data['pages']->withPath(url()->current().$param);

        return view('backend.pages.index', compact('data'), [
            'title' => 'Pages',
            'breadcrumbs' => [
                'Pages' => '',
            ]
        ]);
    }

    public function create(Request $request)
    {
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);
        $data['template'] = $this->serviceTemplate->getTemplate(0);
        $data['fields'] = $this->serviceField->getFieldCategory();

        if (isset($request->parent)) {
            $data['parent'] = $this->service->find($request->parent);
        }

        return view('backend.pages.form', compact('data'), [
            'title' => __('lang.add_attr_new', [
                'attribute' => 'Page'
            ]),
            'routeBack' => route('page.index'),
            'breadcrumbs' => [
                'Page' => route('page.index'),
                __('lang.add') => '',
            ],
        ]);
    }

    public function store(PageRequest $request)
    {
        $this->service->store($request);

        $redir = $this->redirectForm($request);
        return $redir->with('success', __('alert.create_success', [
            'attribute' => 'Page'
        ]));
    }

    public function edit($id)
    {
        $data['page'] = $this->service->find($id);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);
        $data['template'] = $this->serviceTemplate->getTemplate(0);
        $data['fields'] = $this->serviceField->getFieldCategory();

        return view('backend.pages.form-edit', compact('data'), [
            'title' => __('lang.edit_attr', [
                'attribute' => 'Page'
            ]),
            'routeBack' => route('page.index'),
            'breadcrumbs' => [
                'Page' => route('page.index'),
                __('lang.edit') => ''
            ],
        ]);
    }

    public function update(PageRequest $request, $id)
    {
        $this->service->update($request, $id);

        $redir = $this->redirectForm($request);
        return $redir->with('success', __('alert.update_success', [
            'attribute' => 'Page'
        ]));
    }

    public function publish($id)
    {
        $this->service->publish($id);

        return back()->with('success', __('alert.update_success', [
            'attribute' => 'Page'
        ]));
    }

    public function position(Request $request, $id, $position)
    {
        $this->service->position($id, $position, $request->get('parent'));

        return back()->with('success', __('alert.update_success', [
            'attribute' => 'Page'
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
                    'attribute' => 'Page'
                ])
            ], 200);
        }
    }

    public function redirectForm($request)
    {
        $redir = redirect()->route('page.index');
        if ($request->action == 'back') {
            $redir = back();
        }

        return $redir;
    }
}
