<?php

namespace App\Http\Controllers\Admin\Users\ACL;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\ACL\PermissionRequest;
use App\Services\Users\ACL\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    private $service;

    public function __construct(
        PermissionService $service
    )
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $url = $request->url();
        $param = Str::replace($url, '', $request->fullUrl());

        $data['permissions'] = $this->service->getPermissionList($request);
        $data['no'] = $data['permissions']->firstItem();
        $data['permissions']->withPath(url()->current().$param);

        return view('backend.users.ACL.permissions.index', compact('data'), [
            'title' => __('mod/users.permission.title'),
            'breadcrumbs' => [
                __('menu.backend.title3') => 'javascript:;',
                __('mod/users.permission.title') => '',
            ]
        ]);
    }

    public function store(PermissionRequest $request)
    {
        $this->service->store($request);

        return back()->with('success', __('alert.create_success', [
            'attribute' => __('mod/users.permission.caption')
        ]));
    }

    public function update(PermissionRequest $request, $id)
    {
        $this->service->update($request, $id);

        return back()->with('success', __('alert.update_success', [
            'attribute' => __('mod/users.permission.caption')
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
                    'attribute' => __('mod/users.permission.caption')
                ])
            ], 200);
        }
    }
}
