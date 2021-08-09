<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Content\PostRequest;
use App\Services\Content\CategoryService;
use App\Services\Content\PostService;
use App\Services\Content\SectionService;
use App\Services\LanguageService;
use App\Services\Master\Field\FieldCategoryService;
use App\Services\Master\TagService;
use App\Services\Master\TemplateService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    private $service, $serviceSection, $serviceCategory, $serviceLang, 
        $serviceTemplate, $serviceTag, $serviceField;

    public function __construct(
        PostService $service,
        SectionService $serviceSection,
        CategoryService $serviceCategory,
        LanguageService $serviceLang,
        TemplateService $serviceTemplate,
        TagService $serviceTag,
        FieldCategoryService $serviceField
    )
    {
        $this->service = $service;
        $this->serviceSection = $serviceSection;
        $this->serviceCategory = $serviceCategory;
        $this->serviceLang = $serviceLang;
        $this->serviceTemplate = $serviceTemplate;
        $this->serviceTag = $serviceTag;
        $this->serviceField = $serviceField;

        $this->lang = config('custom.language.multiple');
    }

    public function index(Request $request, $sectionId)
    {
        $url = $request->url();
        $param = Str::replace($url, '', $request->fullUrl());

        $data['posts'] = $this->service->getPostList($request, $sectionId);
        $data['no'] = $data['posts']->firstItem();
        $data['posts']->withPath(url()->current().$param);
        $data['section'] = $this->serviceSection->find($sectionId);
        $data['categories'] = $this->serviceCategory->getCategoryBySection($sectionId);

        return view('backend.content.posts.index', compact('data'), [
            'title' => 'Posts',
            'routeBack' => route('section.index'),
            'breadcrumbs' => [
                'Content' => 'javascript:;',
                'Section' => route('section.index'),
                'Posts' => '',
            ]
        ]);
    }

    public function create(Request $request, $sectionId)
    {
        $data['section'] = $this->serviceSection->find($sectionId);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);
        $data['categories'] = $this->serviceCategory->getCategoryBySection($sectionId);
        $data['template'] = $this->serviceTemplate->getTemplate(3);
        $data['fields'] = $this->serviceField->getFieldCategory();

        return view('backend.content.posts.form', compact('data'), [
            'title' => __('lang.add_attr_new', [
                'attribute' => 'Post'
            ]),
            'routeBack' => route('post.index', ['sectionId' => $sectionId]),
            'breadcrumbs' => [
                'Content' => 'javascript:;',
                'Section' => route('section.index'),
                'Post' => route('post.index', ['sectionId' => $sectionId]),
                __('lang.add') => '',
            ],
        ]);
    }

    public function store(PostRequest $request, $sectionId)
    {
        $this->service->store($request, $sectionId);

        $redir = $this->redirectForm($request, $sectionId);
        return $redir->with('success', __('alert.create_success', [
            'attribute' => 'Post'
        ]));
    }

    public function edit($sectionId, $id)
    {
        $data['post'] = $this->service->find($id);
        $data['section'] = $this->serviceSection->find($sectionId);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);
        $data['categories'] = $this->serviceCategory->getCategoryBySection($sectionId);
        $data['template'] = $this->serviceTemplate->getTemplate(3);
        $data['fields'] = $this->serviceField->getFieldCategory();

        $tag = [];
        foreach ($data['post']->tags as $key => $value) {
            $tag[$key] = $value->tag->name;
        }

        $data['tags'] = implode(',', $tag);

        return view('backend.content.posts.form-edit', compact('data'), [
            'title' => __('lang.edit_attr', [
                'attribute' => 'Post'
            ]),
            'routeBack' => route('post.index', ['sectionId' => $sectionId]),
            'breadcrumbs' => [
                'Content' => 'javascript:;',
                'Section' => route('section.index'),
                'Post' => route('post.index', ['sectionId' => $sectionId]),
                __('lang.edit') => ''
            ],
        ]);
    }

    public function update(PostRequest $request, $sectionId, $id)
    {
        $this->service->update($request, $id);

        $redir = $this->redirectForm($request, $sectionId);
        return $redir->with('success', __('alert.update_success', [
            'attribute' => 'Post'
        ]));
    }

    public function publish($sectionId, $id)
    {
        $this->service->publish($id);

        return back()->with('success', __('alert.update_success', [
            'attribute' => 'Post'
        ]));
    }

    public function selection($sectionId, $id)
    {
        $post = $this->service->find($id);
        $check = $this->service->selection($id);

        if ($check == true) {
            return back()->with('success', __('alert.update_success', [
                'attribute' => 'Post'
            ]));
        } else {
            return back()->with('warning', 'Cannot select post because post 
                select limited '.$post->section->post_selection);
        }
    }

    public function position($sectionId, $id, $position)
    {
        $this->service->position($id, $position);

        return back()->with('success', __('alert.update_success', [
            'attribute' => 'Post'
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
                    'attribute' => 'Post'
                ])
            ], 200);
        }
    }

    public function destroyFile($sectionId, $id)
    {
        $this->service->deleteFile($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }

    public function redirectForm($request, $sectionId)
    {
        $redir = redirect()->route('post.index', ['sectionId' => $sectionId]);
        if ($request->action == 'back') {
            $redir = back();
        }

        return $redir;
    }
}
