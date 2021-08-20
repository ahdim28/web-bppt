<?php

namespace App\Http\Controllers;

use App\Services\ConfigurationService;
use App\Services\Deputi\StructureOrganizationService;
use App\Services\Page\PageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class PageViewController extends Controller
{
    private $service, $serviceStructure, $config;

    public function __construct(
        PageService $service,
        StructureOrganizationService $serviceStructure,
        ConfigurationService $config
    )
    {
        $this->service = $service;
        $this->serviceStructure = $serviceStructure;
        $this->config = $config;
    }

    public function list(Request $request)
    {
        return redirect()->route('home');

        //data
        $data['banner'] = $this->config->getFile('banner_default');
        $limit = $this->config->getValue('content_limit');
        $data['pages'] = $this->service->getPage($request, true, $limit);

        return view('frontend.pages.list', compact('data'), [
            'title' => 'Pages',
            'breadcrumbs' => [
                'Pages' => '',
            ],
        ]);
    }

    public function read(Request $request)
    {
        $slug = $request->route('slug');

        $data['read'] = $this->service->findBySlug($slug);

        //check
        if (empty($slug)) {
            return abort(404);
        }

        if ($data['read']->publish == 0 || empty($data['read']) || 
            $data['read']->is_detail == 0) {
            return redirect()->route('home');
        }

        if ($slug != $data['read']->slug) {
            return redirect()->route('page.read.'.$data['read']->slug);
        }

        if ($data['read']->public == 0 && Auth::guard()->check() == false) {
            return redirect()->route('home')->with('warning', 'You must login first');
        }

        $this->service->recordViewer($data['read']->id);

        //data
        $data['childs'] = $data['read']->childPublish;
        $data['medias'] = $data['read']->media()->orderBy('position', 'ASC')->get();
        $data['fields'] = $data['read']->custom_field;

        // meta data
        $data['meta_title'] = $data['read']->fieldLang('title');
        if (!empty($data['read']->meta_data['title'])) {
            $data['meta_title'] = Str::limit(strip_tags($data['read']->meta_data['title']), 69);
        }

        $data['meta_description'] = $this->config->getValue('meta_description');
        if (!empty($data['read']->meta_data['description'])) {
            $data['meta_description'] = $data['read']->meta_data['description'];
        } elseif (empty($data['read']->meta_data['description']) && 
            !empty($data['read']->fieldLang('intro'))) {
            $data['meta_description'] = Str::limit(strip_tags($data['read']->fieldLang('intro')), 155);
        } elseif (empty($data['read']->meta_data['description']) && 
            empty($data['read']->fieldLang('intro')) && !empty($data['read']->fieldLang('content'))) {
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

        $blade = 'detail';
        if (!empty($data['read']->custom_view_id)) {
            $blade = config('custom.templates.path.pages.custom').'.'.
                collect(explode("/", $data['read']->customView->file_path))->last();
        }

        $breadcrumbs = [];
        foreach ($data['read']->where('id', $data['read']->parent)->orderBy('position', 'ASC')->get() as $breadA) {
            foreach ($breadA->where('id', $breadA->parent)->orderBy('position', 'ASC')->get() as $breadB) {
                $breadcrumbs[Str::limit($breadB->fieldLang('title'), 15)] = route('page.read.'.$breadB->slug);
            }
            $breadcrumbs[Str::limit($breadA->fieldLang('title'), 15)] = route('page.read.'.$breadA->slug);
        }
        $breadcrumbs[Str::limit($data['read']->fieldLang('title'), 15)] = '';

        return view('frontend.pages.'.$blade, compact('data'), [
            'title' => $data['read']->fieldLang('title'),
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * addon
     */
    public function listStructure(Request $request)
    {
        return redirect()->route('home');

        //data
        $data['banner'] = $this->config->getFile('banner_default');
        $limit = $this->config->getValue('content_limit');
        $data['structures'] = $this->serviceStructure->getStructure($request, true, $limit);

        return view('frontend.structure.list', compact('data'), [
            'title' => __('common.structure_caption'),
            'breadcrumbs' => [
                __('common.structure_caption') => '',
            ],
        ]);
    }

    public function readStructure(Request $request)
    {
        $slug = $request->route('slugStructure');

        $data['read'] = $this->serviceStructure->findBySlug($slug);
        $data['sidadu'] = $this->serviceStructure->getSidaduApi($data['read']->unit_code);

        //check
        if (empty($slug)) {
            return abort(404);
        }

        if ($slug != $data['read']->slug) {
            return redirect()->route('structure.read', ['slugStructure' => $data['read']->slug]);
        }

        // meta data
        $data['meta_title'] = $data['read']->fieldLang('name');
        $data['meta_description'] = $this->config->getValue('meta_description');
        if (!empty($data['read']->fieldLang('description'))) {
            $data['meta_description'] = Str::limit(strip_tags($data['read']->fieldLang('description')), 155);
        }

        //images
        $data['creator'] = $data['read']->createBy->name;
        $data['banner'] = $this->config->getFile('banner_default');

        return view('frontend.structure.detail', compact('data'), [
            'title' => $data['read']->fieldLang('name'),
            'breadcrumbs' => [
                __('common.structure_caption') => '',
                Str::limit($data['read']->fieldLang('name'), 15) => ''
            ],
        ]);
    }
}
