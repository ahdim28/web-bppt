<?php

namespace App\Services\Master\Field;

use App\Models\Master\Field\FieldCategory;
use Illuminate\Support\Facades\Auth;

class FieldCategoryService
{
    private $model;

    public function __construct(
        FieldCategory $model
    )
    {
        $this->model = $model;   
    }

    public function getFieldCategoryList($request)
    {
        $query = $this->model->query();

        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('name', 'like', '%'.$q.'%')
                    ->orWhere('description', 'like', '%'.$q.'%');
            });
        });

        $limit = 20;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->orderBy('id', 'ASC')->paginate($limit);

        return $result;
    }

    public function getFieldCategory()
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
        $category = new FieldCategory($request->only(['name']));
        $category->description = $request->description ?? null;
        $category->created_by = Auth::user()->id;
        $category->save();

        return $category;
    }

    public function update($request, int $id)
    {
        $category = $this->find($id);
        $category->fill($request->only(['name']));
        $category->description = $request->description ?? null;
        $category->updated_by = Auth::user()->id;
        $category->save();

        return $category;
    }

    public function delete(int $id)
    {
        $find = $this->find($id);
        
        $page = $find->pages->count();
        $section = $find->sections->count();
        $category = $find->categories->count();
        $post = $find->posts->count();
        $catalogCategory = $find->catalogCategories->count();
        $catalogProduct = $find->catalogProducts->count();
        $album = $find->albums->count();
        $playlist = $find->playlists->count();
        $link = $find->links->count();
        $linkMedia = $find->linkMedia->count();
        $inquiry = $find->inquiries->count();

        if ($page == 0 && $section == 0 && $category == 0 && $post == 0 &&
            $catalogCategory == 0 && $catalogProduct == 0 && $album == 0 &&
            $playlist == 0 && $link == 0 && $linkMedia == 0 && $inquiry == 0) {

            $find->fields()->delete();
            $find->delete();

            return true;

        } else {
             return false;
        }     
    }
}