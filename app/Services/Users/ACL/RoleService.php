<?php

namespace App\Services\Users\ACL;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class RoleService
{
    private $model;

    public function __construct(
        Role $model
    )
    {
        $this->model = $model;
    }

    public function getRoleList($request)
    {
        $query = $this->model->query();

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

    public function getRoleByUser($allRole = true)
    {
        $query = $this->model->query();

        if ($allRole == false) {
            $query->where('id', '>=', Auth::user()->roles[0]->id);
            // $query->whereNotIn('name', ['roles_add']);
        }

        if ($allRole == true && !Auth::user()->hasRole('super|support')) {
            $query->whereNotIn('name', ['super', 'support']);
        }

        $result = $query->get();

        return $result;
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function store($request)
    {
        $role = new Role;
        $role->name = $this->generateField($request->name);
        $role->guard_name = 'web';
        $role->save();

        return $role;
    }

    public function update($request, int $id)
    {
        $role = $this->find($id);
        $role->name = $this->generateField($request->name);
        $role->save();

        return $role;
    }

    public function generateField($fieldName)
    {
        return Str::slug($fieldName, '_');
    }

    public function setPermission($request, int $id)
    {
        $role = $this->find($id);
        $role->syncPermissions($request->permission);

        return $role;
    }

    public function delete(int $id)
    {
        $role = $this->find($id);

        $checkHasRole = DB::table('model_has_roles')->where('role_id', $id)
            ->count();
        $checkHasPermission = DB::table('role_has_permissions')->where('role_id', $id)
            ->count();

        if ($checkHasRole == 0 && $checkHasPermission == 0) {
            
            $role->delete();
            return $role;

        } else {
            return false;
        }
    }
}