<?php

namespace App\Http\Controllers\Admin\Link;

use App\Http\Controllers\Controller;
use App\Http\Requests\Link\LinkMediaRequest;
use App\Services\LanguageService;
use App\Services\Link\LinkMediaService;
use App\Services\Link\LinkService;
use App\Services\Master\Field\FieldCategoryService;
use Illuminate\Http\Request;

class LinkMediaController extends Controller
{
    private $service, $serviceLink, $serviceLang, $serviceField;

    public function __construct(
        LinkMediaService $service,
        LinkService $serviceLink,
        LanguageService $serviceLang,
        FieldCategoryService $serviceField
    )
    {
        $this->service = $service;
        $this->serviceLink = $serviceLink;
        $this->serviceLang = $serviceLang;
        $this->serviceField = $serviceField;

        $this->lang = config('custom.language.multiple');
    }

    public function index(Request $request, $linkId)
    {
        $url = $request->url();
        $param = str_replace($url, '', $request->fullUrl());

        $data['medias'] = $this->service->getLinkMediaList($request, $linkId);
        $data['no'] = $data['medias']->firstItem();
        $data['medias']->withPath(url()->current().$param);
        $data['link'] = $this->serviceLink->find($linkId);

        return view('backend.links.medias.index', compact('data'), [
            'title' => 'Link Media',
            'routeBack' => route('link.index'),
            'breadcrumbs' => [
                'Link' => route('link.index'),
                'Media' => '',
            ]
        ]);
    }

    public function create($linkId)
    {
        $data['link'] = $this->serviceLink->find($linkId);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);
        $data['fields'] = $this->serviceField->getFieldCategory();

        return view('backend.links.medias.form', compact('data'), [
            'title' => 'Add New Media',
            'routeBack' => route('link.media.index', ['linkId' => $linkId]),
            'breadcrumbs' => [
                'Link' => route('link.index'),
                'Media' => route('link.media.index', ['linkId' => $linkId]),
                'Add' => '',
            ],
        ]);
    }

    public function store(LinkMediaRequest $request, $linkId)
    {
        $this->service->store($request, $linkId);

        $redir = $this->redirectForm($request, $linkId);
        return $redir->with('success', 'media successfully added');
    }

    public function edit($linkId, $id)
    {
        $data['media'] = $this->service->find($id);
        $data['link'] = $this->serviceLink->find($linkId);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);
        $data['fields'] = $this->serviceField->getFieldCategory();

        return view('backend.links.medias.form-edit', compact('data'), [
            'title' => 'Edit Media',
            'routeBack' => route('link.media.index', ['linkId' => $linkId]),
            'breadcrumbs' => [
                'Link' => route('link.index'),
                'Media' => route('link.media.index', ['linkId' => $linkId]),
                'Edit' => '',
            ],
        ]);
    }

    public function update(LinkMediaRequest $request, $linkId, $id)
    {
        $this->service->update($request, $id);

        $redir = $this->redirectForm($request, $linkId);
        return $redir->with('success', 'media successfully updated');
    }

    public function position($linkId, $id, $position)
    {
        $this->service->position($id, $position);

        return back()->with('success', 'position media changed');
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }

    public function redirectForm($request, $linkId)
    {
        $redir = redirect()->route('link.media.index', ['linkId' => $linkId]);
        if ($request->action == 'back') {
            $redir = back();
        }

        return $redir;
    }
}
