<?php

namespace App\Services\Master;

use App\Models\Master\Tags\Tag;
use App\Models\Master\Tags\TagType;
use Illuminate\Support\Facades\Auth;

class TagService
{
    private $model, $modelType;

    public function __construct(
        Tag $model,
        TagType $modelType
    )
    {
        $this->model = $model;
        $this->modelType = $modelType;
    }

    public function getTagList($request)
    {
        $query = $this->model->query();

        $query->when($request, function ($query, $f) {
            if ($f->f != '') {
                $query->where('flags', $f->f);
            }
        })->when($request, function ($query, $s) {
            if ($s->s != '') {
                $query->where('standar', $s->s);
            }
        })->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('name', 'like', '%'.$q.'%');
            });
        });

        $limit = 20;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->orderBy('id', 'ASC')->paginate($limit);

        return $result;
    }

    public function getTag()
    {
        $query = $this->model->query();

        $query->flags();

        $result = $query->orderBy('id', 'ASC')->get();

        return $result;
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function store($request)
    {
        $tags = new Tag($request->only(['name']));
        $tags->description = $request->description ?? null;
        $tags->created_by = Auth::user()->id;
        $tags->save();

        return $tags;
    }

    public function update($request, int $id)
    {
        $tags = $this->find($id);
        $tags->fill($request->only(['name']));
        $tags->description = $request->description ?? null;
        $tags->updated_by = Auth::user()->id;
        $tags->save();

        return $tags;
    }

    public function flags(int $id)
    {
        $tags = $this->find($id);
        $tags->flags = !$tags->flags;
        $tags->updated_by = Auth::user()->id;
        $tags->save();

        return $tags;
    }

    public function standar(int $id)
    {
        $tags = $this->find($id);
        $tags->standar = !$tags->standar;
        $tags->updated_by = Auth::user()->id;
        $tags->save();

        return $tags;
    }

    public function delete(int $id)
    {
        $tags = $this->find($id);

        if ($tags->type->count() == 0) {

            $tags->delete();
            return true;
            
        } else {
            return false;
        }
    }

    /**
     * wipe
     */
    public function wipeStore($request, $model)
    {
        $tagName = explode(',',$request->tags);
        // $tagName = array_map('strtolower', $tagName);

        $tag = new Tag;
        foreach($tagName as $name) {
            $tag->updateOrCreate([
                'name' => $name
            ], [
                'created_by' => Auth::user()->id,
                'name' => $name,
            ]);
        }

        $this->wipeAndUpdate($model, $tagName);

        return true;
    }

    public function wipe($model)
    {
        $query = $this->modelType->query();

        $query->where('tagable_id', $model->tagable_id)
            ->where('tagable_type', $model->tagable_type)
            ->get();
        
        $query->delete();
    }

    public function wipeAndUpdate($model, $tags = null)
    {
        $tagType = new TagType;

        $model = $tagType->tagable()->associate($model);
        $this->wipe($model);

        if ($tags != null) {
            foreach($tags as $name) {
                $tagId = $this->model->where('name', $name)->first()->id;
                $tagType->updateOrCreate([
                    'tag_id' => $tagId,
                    'tagable_id' => $model->tagable_id,
                    'tagable_type' => $model->tagable_type,
                ], [
                    'tag_id' => $tagId,
                    'tagable_id' => $model->tagable_id,
                    'tagable_type' => $model->tagable_type,
                ]);
            }
        }

        return true;
    }
}