<?php

namespace App\Http\Controllers;

use App\Services\ConfigurationService;
use App\Services\Page\PageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class PageViewController extends Controller
{
    private $service, $config;

    public function __construct(
        PageService $service,
        ConfigurationService $config
    )
    {
        $this->service = $service;
        $this->config = $config;
    }

    public function list(Request $request)
    {
        return redirect()->route('home');

        //data
        $data['banner'] = $this->config->getFile('banner_default');
        $limit = $this->config->getValue('content_limit');
        $data['pages'] = $this->service->getPage($request, 'paginate', $limit);

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

        if ($data['read']->public == 0 && auth()->guard()->check() == false) {
            return redirect()->route('home')->with('warning', 'You must login first');
        }

        $this->service->recordViewer($data['read']->id);

        //data
        $data['childs'] = $data['read']->childs()->orderBy('position', 'ASC')->get();
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

        return view('frontend.pages.'.$blade, compact('data'), [
            'title' => $data['read']->fieldLang('title'),
            'breadcrumbs' => [
                $data['read']->fieldLang('title') => ''
            ],
        ]);
    }
}
