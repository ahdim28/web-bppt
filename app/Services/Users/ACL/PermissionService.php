<?php

namespace App\Services\Users\ACL;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class PermissionService
{
    private $model;

    public function __construct(
        Permission $model
    )
    {
        $this->model = $model;
    }

    public function getPermissionList($request)
    {
        $query = $this->model->query();

        $query->where('parent', 0);
        $query->when($request->q, function ($query, $q) {
            $query->where('name', 'like', '%'.$q.'%');
        });

        $limit = 20;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->paginate($limit);

        return $result;
    }

    public function getPermission()
    {
        $query = $this->model->query();

        $result = $query->get();

        return $result;
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function store($request)
    {
        $permission = new Permission;
        $permission->parent = $request->parent;
        $permission->name = $this->generateField($request->name);
        $permission->guard_name = 'web';
        $permission->save();

        return $permission;
    }

    public function update($request, int $id)
    {
        $permission = $this->find($id);
        $permission->name = $this->generateField($request->name);
        $permission->save();

        return $permission;
    }

    public function generateField($fieldName)
    {
        return Str::slug($fieldName, '_');
    }

    public function delete(int $id)
    {
        $permission = $this->find($id);

        $checkHas = DB::table('role_has_permissions')->where('permission_id', $id)
            ->count();

        if ($checkHas == 0) {
            
            $this->model->where('parent', $id)->delete();
            $permission->delete();
    
            return $permission;

        } else {
            return false;
        }
    }
}