<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\TemplateRequest;
use App\Services\Master\TemplateService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TemplateController extends Controller
{
    private $service;

    public function __construct(
        TemplateService $service
    )
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $url = $request->url();
        $param = Str::replace($url, '', $request->fullUrl());

        $data['templates'] = $this->service->getTemplateList($request);
        $data['no'] = $data['templates']->firstItem();
        $data['templates']->withPath(url()->current().$param);

        return view('backend.master.templates.index', compact('data'), [
            'title' => __('mod/master.template.title'),
            'breadcrumbs' => [
                __('mod/master.mod_title') => 'javascript:;',
                __('mod/master.template.title') => '',
            ]
        ]);
    }

    public function create()
    {
        return view('backend.master.templates.form', [
            'title' => __('lang.add_attr_new', [
                'attribute' => __('mod/master.template.caption')
            ]),
            'routeBack' => route('template.index'),
            'breadcrumbs' => [
                __('mod/master.mod_title') => 'javascript:;',
                __('mod/master.template.caption') => route('template.index'),
                __('lang.add') => '',
            ]
        ]);
    }

    public function store(TemplateRequest $request)
    {
        $this->service->store($request);

        $redir = $this->redirectForm($request);
        return $redir->with('success', __('alert.create_success', [
            'attribute' => __('mod/master.template.caption')
        ]));
    }

    public function edit($id)
    {
        $data['template'] = $this->service->find($id);

        return view('backend.master.templates.form', compact('data'), [
            'title' => __('lang.edit_attr', [
                'attribute' => __('mod/master.template.caption')
            ]),
            'routeBack' => route('template.index'),
            'breadcrumbs' => [
                __('mod/master.mod_title') => 'javascript:;',
                __('mod/master.template.caption') => route('template.index'),
                __('lang.edit') => '',
            ]
        ]);
    }

    public function update(TemplateRequest $request, $id)
    {
        $this->service->update($request, $id);

        $redir = $this->redirectForm($request);
        return $redir->with('success', __('alert.update_success', [
            'attribute' => __('mod/master.template.caption')
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
                    'attribute' => __('mod/master.template.caption')
                ])
            ], 200);
        }
    }

    public function redirectForm($request)
    {
        $redir = redirect()->route('template.index');
        if ($request->action == 'back') {
            $redir = back();
        }

        return $redir;
    }
}
