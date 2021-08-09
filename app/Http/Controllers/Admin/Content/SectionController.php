<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Content\SectionRequest;
use App\Services\Content\SectionService;
use App\Services\LanguageService;
use App\Services\Master\Field\FieldCategoryService;
use App\Services\Master\TemplateService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SectionController extends Controller
{
    private $service, $serviceLang, $serviceTemplate, $serviceField;

    public function __construct(
        SectionService $service,
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

        $data['sections'] = $this->service->getSectionList($request);
        $data['no'] = $data['sections']->firstItem();
        $data['sections']->withPath(url()->current().$param);

        return view('backend.content.sections.index', compact('data'), [
            'title' => 'Sections',
            'breadcrumbs' => [
                'Content' => 'javascript:;',
                'Sections' => '',
            ]
        ]);
    }

    public function create(Request $request)
    {
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);
        $data['template_list'] = $this->serviceTemplate->getTemplate(1, 1);
        $data['template_detail'] = $this->serviceTemplate->getTemplate(1, 2);
        $data['fields'] = $this->serviceField->getFieldCategory();

        return view('backend.content.sections.form', compact('data'), [
            'title' => __('lang.add_attr_new', [
                'attribute' => 'Section'
            ]),
            'routeBack' => route('section.index'),
            'breadcrumbs' => [
                'Content' => 'javascript:;',
                'Section' => route('section.index'),
                __('lang.add') => '',
            ],
        ]);
    }

    public function store(SectionRequest $request)
    {
        $this->service->store($request);

        $redir = $this->redirectForm($request);
        return $redir->with('success', __('alert.create_success', [
            'attribute' => 'Section'
        ]));
    }

    public function edit($id)
    {
        $data['section'] = $this->service->find($id);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);
        $data['template_list'] = $this->serviceTemplate->getTemplate(1, 1);
        $data['template_detail'] = $this->serviceTemplate->getTemplate(1, 2);
        $data['fields'] = $this->serviceField->getFieldCategory();

        return view('backend.content.sections.form-edit', compact('data'), [
            'title' => __('lang.edit_attr', [
                'attribute' => 'Section'
            ]),
            'routeBack' => route('section.index'),
            'breadcrumbs' => [
                'Content' => 'javascript:;',
                'Section' => route('section.index'),
                __('lang.edit') => ''
            ],
        ]);
    }

    public function update(SectionRequest $request, $id)
    {
        $this->service->update($request, $id);

        $redir = $this->redirectForm($request);
        return $redir->with('success', __('alert.update_success', [
            'attribute' => 'Section'
        ]));
    }

    public function position($id, $position)
    {
        $this->service->position($id, $position);

        return back()->with('success', __('alert.update_success', [
            'attribute' => 'Section'
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
                    'attribute' => 'Section'
                ])
            ], 200);
        }
    }

    public function redirectForm($request)
    {
        $redir = redirect()->route('section.index');
        if ($request->action == 'back') {
            $redir = back();
        }

        return $redir;
    }
}
