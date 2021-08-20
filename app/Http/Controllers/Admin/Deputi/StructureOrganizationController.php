<?php

namespace App\Http\Controllers\Admin\Deputi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Deputi\StructureOrganizationRequest;
use App\Services\ConfigurationService;
use App\Services\Deputi\StructureOrganizationService;
use App\Services\LanguageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StructureOrganizationController extends Controller
{
    private $service, $serviceLang;

    public function __construct(
        StructureOrganizationService $service,
        LanguageService $serviceLang
    )
    {
        $this->service = $service;
        $this->serviceLang = $serviceLang;

        $this->lang = config('custom.language.multiple');
    }

    public function index(Request $request)
    {
        $url = $request->url();
        $param = Str::replace($url, '', $request->fullUrl());

        $data['structures'] = $this->service->getStructureList($request);
        $data['no'] = $data['structures']->firstItem();
        $data['structures']->withPath(url()->current().$param);

        return view('backend.structures.index', compact('data'), [
            'title' => 'Structure Organization',
            'breadcrumbs' => [
                'Structure Organization' => '',
            ]
        ]);
    }

    public function create(Request $request)
    {
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);

        return view('backend.structures.form', compact('data'), [
            'title' => __('lang.add_attr_new', [
                'attribute' => 'Structure Organization'
            ]),
            'routeBack' => route('structure.index'),
            'breadcrumbs' => [
                'Structure Organization' => route('structure.index'),
                __('lang.add') => '',
            ],
        ]);
    }

    public function store(StructureOrganizationRequest $request)
    {
        $structure = $this->service->store($request);

        if ($structure == true) {
            $redir = $this->redirectForm($request);
            return $redir->with('success', __('alert.create_success', [
                'attribute' => 'Structure Organization'
            ]));
        } else {
            return back()->with('warning', 'Kode unit tidak tersedia di API');
        }
    }

    public function edit($id)
    {
        $data['structure'] = $this->service->find($id);
        $data['languages'] = $this->serviceLang->getLang(true, $this->lang);

        return view('backend.structures.form-edit', compact('data'), [
            'title' => __('lang.edit_attr', [
                'attribute' => 'Structure Organization'
            ]),
            'routeBack' => route('structure.index'),
            'breadcrumbs' => [
                'Structure Organization' => route('structure.index'),
                __('lang.edit') => ''
            ],
        ]);
    }

    public function update(StructureOrganizationRequest $request, $id)
    {
        $structure = $this->service->update($request, $id);

        if ($structure == true) {
            $redir = $this->redirectForm($request);
            return $redir->with('success', __('alert.create_success', [
                'attribute' => 'Structure Organization'
            ]));
        } else {
            return back()->with('warning', 'Kode unit tidak tersedia di API');
        }
    }

    public function position($id, $position)
    {
        $this->service->position($id, $position);

        return back()->with('success', __('alert.update_success', [
            'attribute' => 'Structure Organization'
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
                    'attribute' => 'Structure Organization'
                ])
            ], 200);
        }
    }

    public function redirectForm($request)
    {
        $redir = redirect()->route('structure.index');
        if ($request->action == 'back') {
            $redir = back();
        }

        return $redir;
    }
}
