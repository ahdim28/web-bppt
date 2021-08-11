<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Content\CategoryRequest;
use App\Services\Content\CategoryService;
use App\Services\Content\SectionService;
use App\Services\LanguageService;
use App\Services\Master\Field\FieldCategoryService;
use App\Services\Master\TemplateService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    private $service, $serviceSection, $serviceLang, $serviceTemplate, $serviceField;

    public function __construct(
        CategoryService $service,
        SectionService $serviceSection,
        LanguageService $serviceLang,
        TemplateService $serviceTemplate,
        FieldCategoryService $serviceField
    )
    {
        $this->service = $service;
        $this->serviceSection = $serviceSection;
        $this->serviceLang = $serviceLang;
        $this->serviceTemplate = $serviceTemplate;
        $this->serviceField = $serviceField;

        $this->lang = config('custom.language.multiple');
    }

    public function index(Request $request, $sectionId)
    {
        $url = $request->url();
        $param = Str::replace($url, '', $request->fullUrl());

        $data['categories'] = $this->service->getCategoryList($request, $sectionId);
        $data['no'] = $data['categories']->firstItem();
        $data['categories']->withPath(url()->current().$param);
        $data['section'] = $this->serviceSection->find($sectionId);

        return view('backend.content.categories.index', compact('data'), [
            'title' => 'Categories',
            'routeBack' => route('section.index'),
            'breadcrumbs' => [
                'Content' => 'javascript:;',
                'Section' => route('section.index'),
                'Categories' => '',
            ]
        ]);
    }

    public function create(Request $request, $sectionId)
    {
        $data['section'] = $this->serviceSection->find($sectionId);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);
        $data['template_list'] = $this->serviceTemplate->getTemplate(2, 1);
        $data['template_detail'] = $this->serviceTemplate->getTemplate(2, 2);
        $data['fields'] = $this->serviceField->getFieldCategory();

        if (isset($request->parent)) {
            $data['parent'] = $this->service->find($request->parent);
        }

        return view('backend.content.categories.form', compact('data'), [
            'title' => __('lang.add_attr_new', [
                'attribute' => 'Category'
            ]),
            'routeBack' => route('category.index', ['sectionId' => $sectionId]),
            'breadcrumbs' => [
                'Content' => 'javascript:;',
                'Section' => route('section.index'),
                'Category' => route('category.index', ['sectionId' => $sectionId]),
                __('lang.add') => '',
            ],
        ]);
    }

    public function store(CategoryRequest $request, $sectionId)
    {
        $this->service->store($request, $sectionId);

        $redir = $this->redirectForm($request, $sectionId);
        return $redir->with('success', __('alert.create_success', [
            'attribute' => 'Category'
        ]));
    }

    public function edit($sectionId, $id)
    {
        $data['category'] = $this->service->find($id);
        $data['section'] = $this->serviceSection->find($sectionId);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);
        $data['template_list'] = $this->serviceTemplate->getTemplate(2, 1);
        $data['template_detail'] = $this->serviceTemplate->getTemplate(2, 2);
        $data['fields'] = $this->serviceField->getFieldCategory();

        return view('backend.content.categories.form-edit', compact('data'), [
            'title' => __('lang.edit_attr', [
                'attribute' => 'Category'
            ]),
            'routeBack' => route('category.index', ['sectionId' => $sectionId]),
            'breadcrumbs' => [
                'Content' => 'javascript:;',
                'Section' => route('section.index'),
                'Category' => route('category.index', ['sectionId' => $sectionId]),
                __('lang.edit') => ''
            ],
        ]);
    }

    public function update(CategoryRequest $request, $sectionId, $id)
    {
        $this->service->update($request, $id);

        $redir = $this->redirectForm($request, $sectionId);
        return $redir->with('success', __('alert.update_success', [
            'attribute' => 'Category'
        ]));
    }

    public function position(Request $request, $sectionId, $id, $position)
    {
        $this->service->position($id, $position, $request->get('parent'));

        return back()->with('success', __('alert.update_success', [
            'attribute' => 'Category'
        ]));
    }

    public function destroy($sectionId, $id)
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

    public function redirectForm($request, $sectionId)
    {
        $redir = redirect()->route('category.index', ['sectionId' => $sectionId]);
        if ($request->action == 'back') {
            $redir = back();
        }

        return $redir;
    }
}
