<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\TagRequest;
use App\Services\Master\TagService;
use Illuminate\Http\Request;

class TagController extends Controller
{
    private $service;

    public function __construct(
        TagService $service
    )
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $url = $request->url();
        $param = str_replace($url, '', $request->fullUrl());

        $data['tags'] = $this->service->getTagList($request);
        $data['no'] = $data['tags']->firstItem();
        $data['tags']->withPath(url()->current().$param);

        return view('backend.master.tags.index', compact('data'), [
            'title' => __('mod/master.tag.title'),
            'breadcrumbs' => [
                __('mod/master.mod_title') => 'javascript:;',
                __('mod/master.tag.title') => '',
            ]
        ]);
    }

    public function create()
    {
        return view('backend.master.tags.form', [
            'title' => __('lang.add_attr_new', [
                'attribute' => __('mod/master.tag.caption')
            ]),
            'routeBack' => route('tag.index'),
            'breadcrumbs' => [
                __('mod/master.mod_title') => 'javascript:;',
                __('mod/master.tag.caption') => route('tag.index'),
                __('lang.add') => '',
            ]
        ]);
    }

    public function store(TagRequest $request)
    {
        $this->service->store($request);

        $redir = $this->redirectForm($request);
        return $redir->with('success', __('alert.create_success', [
            'attribute' => __('mod/master.tag.caption')
        ]));
    }

    public function edit($id)
    {
        $data['tag'] = $this->service->find($id);

        return view('backend.master.tags.form', compact('data'), [
            'title' => __('lang.edit_attr', [
                'attribute' => __('mod/tag.template.caption')
            ]),
            'routeBack' => route('tag.index'),
            'breadcrumbs' => [
                __('mod/master.mod_title') => 'javascript:;',
                __('mod/master.tag.caption') => route('tag.index'),
                __('lang.edit') => '',
            ]
        ]);
    }

    public function update(TagRequest $request, $id)
    {
        $this->service->update($request, $id);

        $redir = $this->redirectForm($request);
        return $redir->with('success', __('alert.update_success', [
            'attribute' => __('mod/master.tag.caption')
        ]));
    }

    public function flags($id)
    {
        $this->service->flags($id);

        return back()->with('success', __('alert.update_success', [
            'attribute' => __('mod/master.tag.caption')
        ]));
    }

    public function standar($id)
    {
        $this->service->standar($id);

        return back()->with('success', __('alert.update_success', [
            'attribute' => __('mod/master.tag.caption')
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
                    'attribute' => __('mod/master.tag.caption')
                ])
            ], 200);
        }
    }

    public function redirectForm($request)
    {
        $redir = redirect()->route('tag.index');
        if ($request->action == 'back') {
            $redir = back();
        }

        return $redir;
    }

    public function apiData()
    {
        $tags = $this->service->getTag()->pluck('name');

        return response()->json($tags, 200);
    }
}
