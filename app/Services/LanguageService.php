<?php

namespace App\Services;

use App\Models\Language;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class LanguageService
{
    private $model;

    public function __construct(
        Language $model
    )
    {
        $this->model = $model;   
    }

    public function getLangList($request, $isTrash = false)
    {
        $query = $this->model->query();

        if ($isTrash == true) {
            $query->onlyTrashed();
        }

        $query->when($request, function ($query, $req) {
            if ($req->s != '') {
                $query->where('status', $req->s);
            }
        })->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('iso_codes', 'like', '%'.$q.'%')
                ->orWhere('country', 'like', '%'.$q.'%')
                ->orWhere('time_zone', 'like', '%'.$q.'%');
            });
        });

        $limit = 20;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->orderBy('id', 'ASC')->paginate($limit);
        if ($isTrash == true) {
            $result = $query->orderBy('deleted_at', 'DESC')->paginate($limit);
        }

        return $result;
    }

    public function getLang($active = true, $multiple = true)
    {
        $query = $this->model->query();

        if ($active == true) {
            $query->active();
        }

        if ($multiple == false) {
            $query->where('iso_codes', App::getLocale());
        }

        $result = $query->get();

        return $result;
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function findByIsoCode($isoCode)
    {
        $query = $this->model->query();

        $query->where('iso_codes', $isoCode);

        $result = $query->first();

        return $result;
    }

    public function store($request)
    {
        $language = new Language($request->only(['country']));
        $language->iso_codes = Str::lower($request->iso_codes);
        $language->description = $request->description ?? null;
        $language->faker_locale = $request->faker_locale ?? null;
        $language->time_zone = $request->time_zone ?? null;
        $language->gmt = $request->gmt ?? null;
        $language->country_code = $request->country_code ?? null;
        $language->icon = Str::replace(url('/storage'), '', $request->icon) ?? null;
        $language->status = (bool)$request->status;
        $language->created_by = Auth::user()->id;
        $language->save();

        $path = resource_path('lang/'.Str::lower($request->iso_codes));
        File::makeDirectory($path, $mode = 0777, true, true);
        File::put($path.'/common.php', '<?php');

        return $language;
    }

    public function update($request, int $id)
    {
        $language = $this->find($id);
        $language->fill($request->only(['country']));
        $language->iso_codes = Str::lower($request->iso_codes);
        $language->description = $request->description ?? null;
        $language->faker_locale = $request->faker_locale ?? null;
        $language->time_zone = $request->time_zone ?? null;
        $language->gmt = $request->gmt ?? null;
        $language->country_code = $request->country_code ?? null;
        $language->icon = Str::replace(url('/storage'), '', $request->icon) ?? null;
        $language->status = (bool)$request->status;
        $language->updated_by = Auth::user()->id;
        $language->save();

        return $language;
    }

    public function status(int $id)
    {
        $language = $this->find($id);
        $language->status = !$language->status;
        $language->updated_by = Auth::user()->id;
        $language->save();

        return $language;
    }

    public function trash(int $id)
    {
        $language = $this->find($id);

        $iso = $language->iso_codes;

        if ($iso == 'id' || $iso == 'en') {
            return false;
        } else {

            $language->deleted_by = Auth::user()->id;
            $language->save();
            $language->delete();

            return true;
        }
    }

    public function delete($request, int $id)
    {
        if ($request->get('is_trash') == 'yes') {
            $language = $this->model->onlyTrashed()->where('id', $id)->first();
        } else {
            $language = $this->find($id);
        }

        if ($language->iso_codes == 'id' || $language->iso_codes == 'en') {
            return false;
        } else {

            File::delete('common.php');
            File::deleteDirectory(resource_path('lang/'.$language->iso_codes));

            $language->forceDelete();

            return true;
        }
    }

    public function restore(int $id)
    {
        $language = $this->model->onlyTrashed()->where('id', $id);
        $language->restore();

        return $language;
    }
}