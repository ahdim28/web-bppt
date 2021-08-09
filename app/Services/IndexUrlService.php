<?php

namespace App\Services;

use App\Models\IndexUrl;
use Illuminate\Support\Str;

class IndexUrlService
{
    private $model;

    public function __construct(
        IndexUrl $model
    )
    {
        $this->model = $model;
    }

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function store($slug, $model)
    {
        $url = new IndexUrl;
        $url->slug = $slug;
        $url->urlable()->associate($model);
        $url->save();

        return $url;
    }

    public function update(int $id, $slug)
    {
        $url = $this->find($id);
        $url->slug = $slug;
        $url->save();

        return $url;
    }

    public function delete($slug)
    {
        $url = $this->model->where('slug', $slug)->first();
        $url->delete();

        return $url;
    }
}