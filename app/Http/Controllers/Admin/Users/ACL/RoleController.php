<?php

namespace App\Http\Controllers\Admin\Users\ACL;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\ACL\RoleRequest;
use App\Services\Users\ACL\PermissionService;
use App\Services\Users\ACL\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    private $service, $servicePermission;

    public function __construct(
        RoleService $service,
        PermissionService $servicePermission
    )
    {
        $this->service = $service;
        $this->servicePermission = $servicePermission;
    }

    public function index(Request $request)
    {
        $url = $request->url();
        $param = Str::replace($url, '', $request->fullUrl());

        $data['roles'] = $this->service->getRoleList($request);
        $data['no'] = $data['roles']->firstItem();
        $data['roles']->withPath(url()->current().$param);

        return view('backend.users.ACL.roles.index', compact('data'), [
            'title' => __('mod/users.role.title'),
            'breadcrumbs' => [
                __('menu.backend.title3') => 'javascript:;',
                __('mod/users.role.caption') => '',
            ]
        ]);
    }

    public function permission(Request $request, $id)
    {
        $data['role'] = $this->service->find($id);

        $collectPermission = collect($data['role']->permissions);
        $data['permission_id'] = $collectPermission->map(function($item, $key) {
            return $item->id;
        })->all();

        $data['permission'] = $this->servicePermission->getPermission()->where('parent', 0);

        return view('backend.users.ACL.roles.set-permission', compact('data'), [
            'title' => __('mod/users.role.set_permission'),
            'routeBack' => route('role.index'),
            'breadcrumbs' => [
                __('menu.backend.title3') => 'javascript:;',
                __('mod/users.role.caption') => route('role.index'),
                __('mod/users.role.set_permission') => '',
            ]
        ]);
    }

    public function store(RoleRequest $request)
    {
        $this->service->store($request);

        return back()->with('success', __('alert.create_success', [
            'attribute' => __('mod/users.role.caption')
        ]));
    }

    public function update(RoleRequest $request, $id)
    {
        $this->service->update($request, $id);

        return back()->with('success', __('alert.update_success', [
            'attribute' => __('mod/users.role.caption')
        ]));
    }

    public function setPermission(Request $request, $id)
    {
        $this->service->setPermission($request, $id);

        $redir = redirect()->route('role.index');
        if ($request->action == 'back') {
            $redir = back();
        }
        
        return $redir->with('success',  __('alert.update_success', [
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
                    'attribute' => __('mod/users.role.caption')
                ])
            ], 200);
        }
        
    }
}
