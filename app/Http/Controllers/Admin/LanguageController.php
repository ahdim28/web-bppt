<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageRequest;
use App\Services\LanguageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LanguageController extends Controller
{
    private $service;

    public function __construct(
        LanguageService $service
    )
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $url = $request->url();
        $param = Str::replace($url, '', $request->fullUrl());

        $data['languages'] = $this->service->getLangList($request);
        $data['no'] = $data['languages']->firstItem();
        $data['languages']->withPath(url()->current().$param);

        return view('backend.languages.index', compact('data'), [
            'title' => __('mod/language.title'),
            'breadcrumbs' => [
                __('mod/language.title') => '',
            ]
        ]);
    }

    public function trash(Request $request)
    {
        $url = $request->url();
        $param = Str::replace($url, '', $request->fullUrl());

        $data['languages'] = $this->service->getLangList($request, true);
        $data['no'] = $data['languages']->firstItem();
        $data['languages']->withPath(url()->current().$param);

        return view('backend.languages.trash', compact('data'), [
            'title' => __('mod/language.title').' '. __('lang.trash'),
            'routeBack' => route('language.index'),
            'breadcrumbs' => [
                __('mod/language.caption') => route('language.index'),
                __('lang.trash') => '',
            ]
        ]);
    }

    public function create()
    {
        return view('backend.languages.form', [
            'title' => __('lang.add_attr_new', [
                'attribute' => __('mod/language.caption')
            ]),
            'routeBack' => route('language.index'),
            'breadcrumbs' => [
                __('mod/language.caption') => route('language.index'),
                __('lang.add') => '',
            ]
        ]);
    }

    public function store(LanguageRequest $request)
    {
        $this->service->store($request);

        $redir = $this->redirectForm($request);
        return $redir->with('success', __('alert.create_success', [
            'attribute' => __('mod/language.caption')
        ]));
    }

    public function edit($id)
    {
        $data['language'] = $this->service->find($id);

        return view('backend.languages.form', compact('data'), [
            'title' => __('lang.edit_attr', [
                'attribute' => __('mod/language.caption')
            ]),
            'routeBack' => route('language.index'),
            'breadcrumbs' => [
                __('mod/language.caption') => route('language.index'),
                __('lang.edit') => '',
            ]
        ]);
    }

    public function update(LanguageRequest $request, $id)
    {
        $this->service->update($request, $id);

        $redir = $this->redirectForm($request);
        return $redir->with('success', __('alert.update_success', [
            'attribute' => __('mod/language.caption')
        ]));
    }

    public function status($id)
    {
        $this->service->status($id);

        return back()->with('success', __('alert.update_success', [
            'attribute' => __('mod/language.caption')
        ]));
    }

    public function softDelete($id)
    {
        $delete = $this->service->trash($id);

        if ($delete == true) {

            return response()->json([
                'success' => 1,
                'message' => ''
            ], 200);

        }  else {

            return response()->json([
                'success' => 0,
                'message' => __('alert.delete_failed_used', [
                    'attribute' => __('mod/language.caption')
                ])
            ], 200);

        }
    }

    public function permanentDelete(Request $request, $id)
    {
        $delete = $this->service->delete($request, $id);

        if ($delete == true) {

            return response()->json([
                'success' => 1,
                'message' => ''
            ], 200);

        } else {

            return response()->json([
                'success' => 0,
                'message' => __('alert.delete_failed_used', [
                    'attribute' => __('mod/language.caption')
                ])
            ], 200);

        }
    }

    public function restore($id)
    {
        $this->service->restore($id);

        return back()->with('success', __('alert.restore_success', [
            'attribute' => __('mod/language.caption')
        ]));
    }

    public function redirectForm($request)
    {
        $redir = redirect()->route('language.index');
        if ($request->action == 'back') {
            $redir = back();
        }

        return $redir;
    }
}
