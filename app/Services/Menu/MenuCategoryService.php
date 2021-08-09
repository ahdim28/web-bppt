<?php

namespace App\Services\Menu;

use App\Models\Menu\MenuCategory;
use Illuminate\Support\Facades\Auth;

class MenuCategoryService
{
    private $model;

    public function __construct(
        MenuCategory $model
    )
    {
        $this->model = $model;
    }

    public function getMenuCategoryList($request)
    {
        $query = $this->model->query();

        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('name', 'like', '%'.$q.'%');
            });
        });

        $limit = 20;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->paginate($limit);

        return $result;
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function store($request)
    {
        $category = new MenuCategory;
        $category->name = $request->name;
        $category->created_by = Auth::user()->id;
        $category->updated_by = Auth::user()->id;
        $category->save();

        return $category;
    }

    public function update($request, int $id)
    {
        $category = $this->find($id);
        $category->name = $request->name;
        $category->updated_by = Auth::user()->id;
        $category->save();

        return $category;
    }

    public function delete(int $id)
    {
        $category = $this->find($id);

        if ($category->menu->count() == 0) {

            $category->delete();
            return true;

        } else {
            return false;
        }
    }
}