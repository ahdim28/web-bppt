<?php

namespace App\Services\Document;

use App\Models\Document\DocumentCategory;
use App\Services\LanguageService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DocumentCategoryService
{
    private $model, $lang;

    public function __construct(
        DocumentCategory $model,
        LanguageService $lang
    )
    {
        $this->model = $model;
        $this->lang = $lang;
    }

    public function getCategoryList($request)
    {
        $query = $this->model->query();

        $query->when($request, function ($query, $req) {
            if ($req->s != '') {
                $query->where('publish', $req->s);
            }
            if ($req->p != '') {
                $query->where('public', $req->p);
            }
        })->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('name->'.App::getLocale(), 'like', '%'.$q.'%');
            });
        });

        $limit = 10;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->where('parent', 0)->orderBy('position', 'ASC')->paginate($limit);

        return $result;
    }

    public function getCategory($request = null, $withPaginate = false, $limit = null)
    {
        $query = $this->model->query();
        
        $query->publish();
        if (Auth::guard()->check() == false) {
            $query->public();
        }

        if (!empty($request)) {
            $this->search($query, $request);
        }

        $query->orderBy('position', 'ASC');
        if ($withPaginate == true) {
            $result = $query->paginate($limit);
        } else {
            if (!empty($limit)) {
                $result = $query->limit($limit)->get();
            } else {
                $result = $query->get();
            }
        }

        return $result;
    }

    public function search($query, $request)
    {
        $query->when($request->keyword, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('name->'.App::getLocale(), 'like', '%'.$q.'%')
                    ->orWhere('description->'.App::getLocale(), 'like', '%'.$q.'%');;
            });
        });
    }

    public function count()
    {
        $query = $this->model->query();

        $query->publish();
        $result = $query->count();

        return $result;
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function findBySlug($slug)
    {
        $query = $this->model->query();

        $query->where('slug', $slug);
        $result = $query->first();

        return $result;
    }

    public function store($request)
    {
        $parent = $request->parent ?? 0;
        
        $category = new DocumentCategory;
        $category->parent = $parent;
        $this->setField($request, $category);
        $category->position = $this->model->where('parent', (int)$parent)->max('position') + 1;
        $category->created_by = Auth::user()->id;
        $category->save();

        return $category;
    }

    public function update($request, int $id)
    {
        $category = $this->find($id);
        $this->setField($request, $category);
        $category->updated_by = Auth::user()->id;
        $category->save();

        return $category;
    }

    public function setField($request, $category)
    {
        foreach ($this->lang->getLang(false, true) as $key => $value) {
            $name[$value->iso_codes] = ($request->input('name_'.$value->iso_codes) == null) ?
                $request->input('name_'.config('custom.language.default')) : $request->input('name_'.$value->iso_codes);
            $description[$value->iso_codes] = ($request->input('description_'.$value->iso_codes) == null) ?
                $request->input('description_'.config('custom.language.default')) : $request->input('description_'.$value->iso_codes);
        }

        // $category->slug = Str::limit(Str::slug($request->slug, '-'), 50);
        $category->slug = Str::slug($request->slug, '-');
        $category->name = $name;
        $category->description = $description;
        $category->publish = (bool)$request->publish;
        $category->public = (bool)$request->public;
        $category->banner = [
            'file_path' => Str::replace(url('storage/'), '', $request->banner_file) ?? null,
            'title' => $request->banner_title ?? null,
            'alt' => $request->banner_alt ?? null,
        ];

        return $category;
    }

    public function position(int $id, int $position, int $parent = null)
    {
        if ($position >= 1) {

            $category = $this->find($id);

            if ($parent != null) {
                $this->model->where('position', $position)->where('parent', $parent)->update([
                    'position' => $category->position,
                ]);
            } else {
                $this->model->where('position', $position)->where('parent', 0)->update([
                    'position' => $category->position,
                ]);
            }

            $category->position = $position;
            $category->updated_by = Auth::user()->id;
            $category->save();

            return $category;
        }
    }

    public function publish(int $id)
    {
        $category = $this->find($id);
        $category->publish = !$category->publish;
        $category->updated_by = Auth::user()->id;
        $category->save();

        return $category;
    }

    public function recordViewer(int $id)
    {
        $category = $this->find($id);
        $category->viewer = ($category->viewer+1);
        $category->save();

        return $category;
    }

    public function delete(int $id)
    {
        $category = $this->find($id);

        $parent = $this->model->where('parent', $id)->count();
        $document = $category->documents->count();

        if ($parent == 0 && $document == 0) {

            foreach ($this->model->where('parent', $id)->get() as $valueA) {

                $valueA->delete();

                foreach ($this->model->where('parent', $valueA->id)->get() as $valueB) {

                    $valueB->delete();
                }
            }

            $category->delete();
            return true;

        } else {
            return false;
        }
    }
}