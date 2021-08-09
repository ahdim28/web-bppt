<?php

namespace App\Http\Controllers;

use App\Services\ConfigurationService;
use App\Services\Link\LinkMediaService;
use App\Services\Link\LinkService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LinkViewController extends Controller
{
    private $serviceLink, $serviceLinkMedia, $config;

    public function __construct(
        LinkService $serviceLink,
        LinkMediaService $serviceLinkMedia,
        ConfigurationService $config
    )
    {
        $this->serviceLink = $serviceLink;
        $this->serviceLinkMedia = $serviceLinkMedia;
        $this->config = $config;
    }

    public function list(Request $request)
    {
        return redirect()->route('home');

        $data['banner'] = $this->config->getFile('banner_default');
        $limit = $this->config->getValue('content_limit');
        $data['link'] = $this->serviceLink->getLink($request, 'paginate', $limit);
        $data['link_medias'] = $this->serviceLinkMedia->getLinkMedia($request, 'paginate', $limit);

        return view('frontend.links.list', compact('data'), [
            'title' => 'Links',
            'breadcrumbs' => [
                'Links' => '',
            ],
        ]);
    }

    public function read(Request $request)
    {
        $slug = $request->route('slug');

        $data['read'] = $this->serviceLink->findBySlug($slug);

        //check
        if (empty($slug)) {
            return abort(404);
        }

        if ($data['read']->publish == 0 || empty($data['read']) || $data['read']->is_detail == 0) {
            return redirect()->route('home');
        }

        if ($slug != $data['read']->slug) {
            return redirect()->route('link.read.'.$data['read']->slug);
        }

        $this->serviceLink->recordViewer($data['read']->id);

        //data
        $limit = $this->config->getValue('content_limit');
        if (!empty($data['read']->media_limit)) {
            $limit = $data['read']->media_limit;
        }
        $data['medias'] = $this->serviceLinkMedia->getLinkMedia($request, null, null, $data['read']->id);
        $data['field'] = $data['read']->custom_field;

        // meta data
        $data['meta_title'] = $data['read']->fieldLang('name');
        if (!empty($data['read']->meta_data['title'])) {
            $data['meta_title'] = Str::limit(strip_tags($data['read']->meta_data['title']), 69);
        }

        $data['meta_description'] = $this->config->getValue('meta_description');
        if (!empty($data['read']->meta_data['description'])) {
            $data['meta_description'] = $data['read']->meta_data['description'];
        } elseif (empty($data['read']->meta_data['description']) && !empty($data['read']->fieldLang('description'))) {
            $data['meta_description'] = Str::limit(strip_tags($data['read']->fieldLang('description')), 155);
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

        $blade = 'detail';
        if (!empty($data['read']->custom_view_id)) {
            $blade = config('custom.templates.path.links.custom').'.'.
                collect(explode("/", $data['read']->customView->file_path))->last();
        }

        return view('frontend.links.'.$blade, compact('data'), [
            'title' => $data['read']->fieldLang('name'),
            'breadcrumbs' => [
                $data['read']->fieldLang('name') => ''
            ],
        ]);
    }
}
