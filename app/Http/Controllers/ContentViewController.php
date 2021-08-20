<?php

namespace App\Http\Controllers;

use App\Services\ConfigurationService;
use App\Services\Content\CategoryService;
use App\Services\Content\PostService;
use App\Services\Content\SectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ContentViewController extends Controller
{
    private $serviceSection, $serviceCategory, $servicePost, $config;

    public function __construct(
        SectionService $serviceSection,
        CategoryService $serviceCategory,
        PostService $servicePost,
        ConfigurationService $config
    )
    {
        $this->serviceSection = $serviceSection;
        $this->serviceCategory = $serviceCategory;
        $this->servicePost = $servicePost;
        $this->config = $config;
    }

    /**
     * section
     */
    public function listSection(Request $request)
    {
        return redirect()->route('home');

        //data
        $data['banner'] = $this->config->getFile('banner_default');
        $limit = $this->config->getValue('content_limit');
        $data['sections'] = $this->serviceSection->getSection($request, true, $limit);

        return view('frontend.content.sections.list', compact('data'), [
            'title' => 'Sections',
            'breadcrumbs' => [
                'Sections' => ''
            ],
        ]);
    }

    public function readSection(Request $request)
    {
        $slug = $request->route('slug');

        $data['read'] = $this->serviceSection->findBySlug($slug);

        //check
        if (empty($slug)) {
            return abort(404);
        }

        if (empty($data['read']) || $data['read']->is_detail == 0) {
            return redirect()->route('home');
        }

        if ($slug != $data['read']->slug) {
            return redirect()->route('section.read.'.$data['read']->slug);
        }

        if ($data['read']->public == 0 && auth()->guard()->check() == false) {
            return redirect()->route('home')->with('warning', 'You must login first');
        }

        $this->serviceSection->recordViewer($data['read']->id);

        //data
        $categoryLimit = $this->config->getValue('content_limit');
        $postLimit = $this->config->getValue('content_limit');

        if (!empty($request->l)) {
            $categoryLimit = $request->l;
            $postLimit = $request->l;
        }

        if (!empty($data['read']->limit_category) && empty($request->l)) {
            $categoryLimit = $data['read']->limit_category;
        }

        if (!empty($data['read']->limit_post) && empty($request->l)) {
            $postLimit = $data['read']->limit_post;
        }

        $url = $request->url();
        $param = Str::replace($url, '', $request->fullUrl());

        $data['categories'] = $this->serviceCategory->getCategory($request, true, $categoryLimit, $data['read']->id);
        $data['categories']->withPath(url()->current().$param);
        $data['posts'] = $this->servicePost->getPost($request, true, $postLimit, 'section', $data['read']->id);
        $data['posts']->withPath(url()->current().$param);
        $data['field'] = $data['read']->custom_field;

        // meta data
        $data['meta_title'] = $data['read']->fieldLang('name');
        $data['meta_description'] = $this->config->getValue('meta_description');
        if (!empty($data['read']->fieldLang('description'))) {
            $data['meta_description'] = Str::limit(strip_tags($data['read']->fieldLang('description')), 155);
        }

        //images
        $data['creator'] = $data['read']->createBy->name;
        $data['banner'] = $data['read']->bannerSrc($data['read']);

        $blade = 'detail';
        if (!empty($data['read']->list_view_id)) {
            $blade = config('custom.templates.path.sections.list').'.'.
                collect(explode("/", $data['read']->listView->file_path))->last();
        }

        return view('frontend.content.sections.'.$blade, compact('data'), [
            'title' => $data['read']->fieldLang('name'),
            'breadcrumbs' => [
                Str::limit($data['read']->fieldLang('name'), 15) => ''
            ],
        ]);
    }

    /**
     * category
     */
    public function listCategory(Request $request)
    {
        return redirect()->route('home');

        //data
        $data['banner'] = $this->config->getFile('banner_default');
        $limit = $this->config->getValue('content_limit');
        $data['categories'] = $this->serviceCategory->getCategory($request, true, $limit);

        return view('frontend.content.categories.list', compact('data'), [
            'title' => 'Categories',
            'breadcrumbs' => [
                'Categories' => ''
            ],
        ]);
    }

    public function readCategory(Request $request)
    {
        $slug = $request->route('slugCategory');

        $data['read'] = $this->serviceCategory->findBySlug($slug);

        //check
        if (empty($slug)) {
            return abort(404);
        }

        if ($data['read']->publish == 0 || empty($data['read']) || $data['read']->is_detail == 0) {
            return redirect()->route('section.read.'.$data['read']->section->slug);
        }

        if ($slug != $data['read']->slug) {
            return redirect()->route('category.read', ['slugCategory' => $data['read']->slug]);
        }

        if ($data['read']->public == 0 && auth()->guard()->check() == false) {
            return redirect()->route('home')->with('warning', 'You must login first');
        }

        $this->serviceCategory->recordViewer($data['read']->id);

        //data
        $limit = $this->config->getValue('content_limit');
        if (!empty($data['read']->list_limit)) {
            $limit = $data['read']->list_limit;
        }

        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $url = $request->url();
        $param = Str::replace($url, '', $request->fullUrl());

        $data['field'] = $data['read']->custom_field;
        $data['posts'] = $this->servicePost->getPost($request, true, $limit, 'category', $data['read']->id);
        $data['posts']->withPath(url()->current().$param);

        // meta data
        $data['meta_title'] = $data['read']->fieldLang('name');
        $data['meta_description'] = $this->config->getValue('meta_description');
        if (!empty($data['read']->fieldLang('description'))) {
            $data['meta_description'] = Str::limit(strip_tags($data['read']->fieldLang('description')), 155);
        }

        //images
        $data['creator'] = $data['read']->createBy->name;
        $data['banner'] = $data['read']->bannerSrc($data['read']);

        $blade = 'detail';
        if (!empty($data['read']->list_view_id)) {
            $blade = config('custom.templates.path.categories.list').'.'.
                collect(explode("/", $data['read']->listView->file_path))->last();
        }

        return view('frontend.content.categories.'.$blade, compact('data'), [
            'title' => $data['read']->fieldLang('name'),
            'breadcrumbs' => [
                Str::limit($data['read']->section->fieldLang('name'), 15) => route('section.read.'.$data['read']->section->slug),
                Str::limit($data['read']->fieldLang('name'), 15) => ''
            ],
        ]);
    }

    /**
     * post
     */
    public function listPost(Request $request)
    {
        return redirect()->route('home');

        //data
        $data['banner'] = $this->config->getFile('banner_default');
        $limit = $this->config->getValue('content_limit');
        $data['posts'] = $this->servicePost->getPost($request, true, $limit);

        return view('frontend.content.posts.list', compact('data'), [
            'title' => 'Posts',
            'breadcrumbs' => [
                'Posts' => ''
            ],
        ]);
    }

    public function readPost(Request $request)
    {
        $slug = $request->route('slugPost');

        $data['read'] = $this->servicePost->findBySlug($slug);

        //check
        if (empty($slug)) {
            return abort(404);
        }

        if ($data['read']->publish == 0 || empty($data['read']) || $data['read']->is_detail == 0) {
            return redirect()->route('home');
        }

        if ($slug != $data['read']->slug) {
            return redirect()->route('post.read', ['slug' => $data['read']->slug]);
        }

        if ($data['read']->public == 0 && auth()->guard()->check() == false) {
            return redirect()->route('home')->with('warning', 'You must login first');
        }

        $this->servicePost->recordViewer($data['read']->id);

        //data
        // $data['files'] = $data['read']->files;
        // $data['profile'] = $data['read']->profile;
        $data['event'] = $data['read']->event;
        $data['media'] = $data['read']->media()->orderBy('position', 'ASC')->get();
        // $data['field'] = $data['read']->custom_field;
        $data['latest_post'] = $this->servicePost->latestPost($data['read']->id, 6, 'section');
        // $data['prev_post'] = $this->servicePost->postPrevNext($data['read']->id, 1, 'prev', 'section');
        // $data['next_post'] = $this->servicePost->postPrevNext($data['read']->id, 1, 'next', 'section');

        // meta data
        $data['meta_title'] = $data['read']->fieldLang('title');
        if (!empty($data['read']->meta_data['title'])) {
            $data['meta_title'] = Str::limit(strip_tags($data['read']->meta_data['title']), 69);
        }

        $data['meta_description'] = $this->config->getValue('meta_description');
        if (!empty($data['read']->meta_data['description'])) {
            $data['meta_description'] = $data['read']->meta_data['description'];
        } elseif (empty($data['read']->meta_data['description']) && !empty($data['read']->fieldLang('intro'))) {
            $data['meta_description'] = Str::limit(strip_tags($data['read']->fieldLang('intro')), 155);
        } elseif (empty($data['read']->meta_data['description']) && empty($data['read']->fieldLang('intro')) 
            && !empty($data['read']->fieldLang('content'))) {
            $data['meta_description'] = Str::limit(strip_tags($data['read']->fieldLang('content')), 155);
        }

        $data['meta_keywords'] = $this->config->getValue('meta_keywords');
        if (!empty($data['read']->meta_data['keywords'])) {
            $data['meta_keywords'] = $data['read']->meta_data['keywords'];
        }

        //images
        $data['creator'] = $data['read']->createBy->name;
        if (!empty($data['read']->cover['file_path'])) {
            $data['cover'] = $data['read']->coverSrc($data['read']);
        }
        $data['banner'] = $data['read']->bannerSrc($data['read']);

        //share
        $data['share_facebook'] = "https://www.facebook.com/share.php?u=".
            URL::full()."&title=".$data['read']->fieldLang('title')."";
        $data['share_twitter'] = "https://twitter.com/intent/tweet?text=".
            $data['read']->fieldLang('title')."&amp;url=".URL::full()."";
        $data['share_whatsapp'] = "whatsapp://send?text=".$data['read']->fieldLang('title')." 
            ".URL::full()."";
        $data['share_linkedin'] = "https://www.linkedin.com/shareArticle?mini=true&url=".
            URL::full()."&title=".$data['read']->fieldLang('title')."&source=".request()->root()."";
        $data['share_pinterest'] = "https://pinterest.com/pin/create/bookmarklet/?media=".
            $data['read']->cover['file_path']."&url=".URL::full()."&is_video=false&description=".$data['read']->fieldLang('title')."";

        $pathView = 'frontend.content.posts.detail';
        if (!empty($data['read']->custom_view_id)) {
            $pathView = 'frontend.content.posts.'.config('custom.templates.path.posts.custom').'.'.
                collect(explode("/", $data['read']->customView->file_path))->last();
        } elseif (!empty($data['read']->section->detail_view_id)) {
            $pathView = 'frontend.content.sections.'.config('custom.templates.path.sections.detail').'.'.
                collect(explode("/", $data['read']->section->detailView->file_path))->last();
        } elseif (!empty($data['read']->category->detail_view_id)) {
            $pathView = 'frontend.content.categories.'.config('custom.templates.path.categories.detail').'.'.
                collect(explode("/", $data['read']->category->detailView->file_path))->last();
        }

        return view($pathView, compact('data'), [
            'title' => $data['read']->fieldLang('title'),
            'breadcrumbs' => [
                Str::limit($data['read']->section->fieldLang('name'), 15) => route('section.read.'.$data['read']->section->slug),
                Str::limit($data['read']->category->fieldLang('name'), 15) => route('category.read.'.$data['read']->section->slug, ['slugCategory' => $data['read']->category->slug]),
                Str::limit($data['read']->fieldLang('title'), 15) => ''
            ],
        ]);
    }
}
