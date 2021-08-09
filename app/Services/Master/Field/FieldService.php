<?php

namespace App\Services\Master\Field;

use App\Models\Master\Field\Field;
use Illuminate\Support\Facades\Auth;

class FieldService
{
    private $model;

    public function __construct(
        Field $model
    )
    {
        $this->model = $model;   
    }

    public function getFieldList($request, int $categoryId)
    {
        $query = $this->model->query();

        $query->where('category_id', $categoryId);
        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('label', 'like', '%'.$q.'%')
                    ->orWhere('name', 'like', '%'.$q.'%');
            });
        });

        $limit = 20;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->orderBy('id', 'ASC')->paginate($limit);

        return $result;
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function store($request, int $categoryId)
    {
        $field = new Field($request->only(['label', 'name', 'type']));
        $field->classes = $request->classes ?? 0;
        $field->category_id = $categoryId;
        $field->created_by = Auth::user()->id;
        $field->save();

        return $field;
    }

    public function update($request, int $id)
    {
        $field = $this->find($id);
        $field->fill($request->only(['label', 'name', 'type']));
        $field->classes = $request->classes ?? 0;
        $field->updated_by = Auth::user()->id;
        $field->save();

        return $field;
    }

    public function delete(int $id)
    {
        $field = $this->find($id);
        $field->delete();

        return true;
    }
}