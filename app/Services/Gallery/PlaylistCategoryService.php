<?php

namespace App\Services\Gallery;

use App\Models\Gallery\PlaylistCategory;
use App\Services\LanguageService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PlaylistCategoryService
{
    private $model, $lang;

    public function __construct(
        PlaylistCategory $model,
        LanguageService $lang
    )
    {
        $this->model = $model;
        $this->lang = $lang;
    }

    public function getPlaylistCategoryList($request)
    {
        $query = $this->model->query();

        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('name->'.App::getLocale(), 'like', '%'.$q.'%')
                    ->orWhere('description->'.App::getLocale(), 'like', '%'.$q.'%');
            });
        });

        $limit = 20;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->orderBy('position', 'ASC')->paginate($limit);

        return $result;
    }

    public function getPlaylistCategory($request = null, $withPaginate = false, $limit = false)
    {
        $query = $this->model->query();

        if (!empty($request)) {
            $query->when($request->q, function ($query, $q) {
                $query->where(function ($query) use ($q) {
                    $query->where('name->'.App::getLocale(), 'like', '%'.$q.'%')
                        ->orWhere('description->'.App::getLocale(), 'like', '%'.$q.'%');
                });
            });
        }

        if (!empty($withPaginate)) {
            $result = $query->orderBy('position', 'ASC')->paginate($limit);
        } else {
            if (!empty($limit)) {
                $result = $query->orderBy('position', 'ASC')->limit($limit)->get();
            } else {
                $result = $query->orderBy('position', 'ASC')->get();
            }
        }

        return $result;
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function store($request)
    {
        $playCat = new PlaylistCategory;
        $playCat->position = $this->model->max('position') + 1;
        $this->setField($request, $playCat);
        $playCat->created_by = Auth::user()->id;
        $playCat->save();

        return $playCat;
    }

    public function update($request, int $id)
    {
        $playCat = $this->find($id);
        $this->setField($request, $playCat);
        $playCat->updated_by = Auth::user()->id;
        $playCat->save();

        return $playCat;
    }

    public function setField($request, $playCat)
    {
        foreach ($this->lang->getLang(false, true) as $key => $value) {
            $name[$value->iso_codes] = ($request->input('name_'.$value->iso_codes) == null) ?
                $request->input('name_'.config('custom.language.default')) : $request->input('name_'.$value->iso_codes);
            $description[$value->iso_codes] = ($request->input('description_'.$value->iso_codes) == null) ?
                $request->input('description_'.config('custom.language.default')) : $request->input('description_'.$value->iso_codes);
        }

        $playCat->slug = Str::limit(Str::slug($request->slug, '-'), 50);
        $playCat->name = $name;
        $playCat->description = $description;

        return $playCat;
    }

    public function position(int $id, int $position)
    {
        if ($position >= 1) {

            $playCat = $this->find($id);
            $this->model->where('position', $position)->update([
                'position' => $playCat->position,
            ]);
            $playCat->position = $position;
            $playCat->updated_by = Auth::user()->id;
            $playCat->save();

            return $playCat;
        }
    }

    public function delete(int $id)
    {
        $playCat = $this->find($id);

        $playlist = $playCat->playlists->count();
        
        if ($playlist == 0) {

            $playCat->delete();
            return true;

        } else {

            return false;
            
        }
    }
}