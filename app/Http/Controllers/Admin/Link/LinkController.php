<?php

namespace App\Http\Controllers\Admin\Link;

use App\Http\Controllers\Controller;
use App\Http\Requests\Link\LinkRequest;
use App\Services\LanguageService;
use App\Services\Link\LinkService;
use App\Services\Master\Field\FieldCategoryService;
use App\Services\Master\TemplateService;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    private $service, $serviceLang, $serviceTemplate, $serviceField;

    public function __construct(
        LinkService $service,
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
        $param = str_replace($url, '', $request->fullUrl());

        $data['links'] = $this->service->getLinkList($request);
        $data['no'] = $data['links']->firstItem();
        $data['links']->withPath(url()->current().$param);

        return view('backend.links.index', compact('data'), [
            'title' => 'Links',
            'breadcrumbs' => [
                'Links' => '',
            ]
        ]);
    }

    public function create()
    {
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);
        $data['template'] = $this->serviceTemplate->getTemplate(8);
        $data['fields'] = $this->serviceField->getFieldCategory();

        return view('backend.links.form', compact('data'), [
            'title' => 'Add New Link',
            'routeBack' => route('link.index'),
            'breadcrumbs' => [
                'Link' => route('link.index'),
                'Add' => '',
            ],
        ]);
    }

    public function store(LinkRequest $request)
    {
        $this->service->store($request);

        $redir = $this->redirectForm($request);
        return $redir->with('success', 'link successfully added');
    }

    public function edit($id)
    {
        $data['link'] = $this->service->find($id);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);
        $data['template'] = $this->serviceTemplate->getTemplate(8);
        $data['fields'] = $this->serviceField->getFieldCategory();

        return view('backend.links.form-edit', compact('data'), [
            'title' => 'Edit Link',
            'routeBack' => route('link.index'),
            'breadcrumbs' => [
                'Link' => route('link.index'),
                'Edit' => '',
            ],
        ]);
    }

    public function update(LinkRequest $request, $id)
    {
        $this->service->update($request, $id);

        $redir = $this->redirectForm($request);
        return $redir->with('success', 'link successfully updated');
    }

    public function publish($id)
    {
        $this->service->publish($id);

        return back()->with('success', 'status link changed');
    }

    public function position($id, $position)
    {
        $this->service->position($id, $position);

        return back()->with('success', 'position link changed');
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
                'message' => 'Cannot delete link, Because this link still has media',
            ], 200);
        }
    }

    public function redirectForm($request)
    {
        $redir = redirect()->route('link.index');
        if ($request->action == 'back') {
            $redir = back();
        }

        return $redir;
    }
}
