<?php

namespace App\Services\Deputi;

use App\Models\Deputi\StructureOrganization;
use App\Services\LanguageService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StructureOrganizationService
{
    private $model, $lang;

    public function __construct(
        StructureOrganization $model,
        LanguageService $lang
    )
    {
        $this->model = $model;  
        $this->lang = $lang;
    }

    public function getStructureList($request)
    {
        $query = $this->model->query();

        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('unit_code', 'like', '%'.$q.'%')
                    ->orWhere('name->'.App::getLocale(), 'like', '%'.$q.'%');
            });
        });

        $limit = 20;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->orderBy('position', 'ASC')->paginate($limit);

        return $result;
    }

    public function getStructure($request = null, $withPaginate = false, $limit = null)
    {
        $query = $this->model->query();

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
        $structure = new StructureOrganization;
        $this->setField($request, $structure);
        $structure->position = $this->model->max('position') + 1;
        $structure->created_by = Auth::user()->id;
        $structure->save();

        $sidadu = $this->getSidaduApi($request->unit_code);

        if (count($sidadu) == 1) {
            return false;
        } else {
            return true;
        }

        return $structure;
    }

    public function update($request, int $id)
    {
        $structure = $this->find($id);
        $this->setField($request, $structure);
        $structure->updated_by = Auth::user()->id;
        $structure->save();

        $sidadu = $this->getSidaduApi($request->unit_code);

        if (count($sidadu) == 1) {
            return false;
        } else {
            return true;
        }

        return $structure;
    }

    public function setField($request, $structure)
    {
        foreach ($this->lang->getLang(false, true) as $key => $value) {
            $name[$value->iso_codes] = ($request->input('name_'.$value->iso_codes) == null) ?
                $request->input('name_'.config('custom.language.default')) : $request->input('name_'.$value->iso_codes);
            $description[$value->iso_codes] = ($request->input('description_'.$value->iso_codes) == null) ?
                $request->input('description_'.config('custom.language.default')) : $request->input('description_'.$value->iso_codes);
        }

        $structure->unit_code = $request->unit_code ?? null;
        // $structure->slug = Str::limit(Str::slug($request->slug, '-'), 50);
        $structure->slug = Str::slug($request->slug, '-');
        $structure->name = $name;
        $structure->description = $description;

        return $structure;
    }

    public function position(int $id, int $position)
    {
        if ($position >= 1) {

            $structure = $this->find($id);
            $this->model->where('position', $position)->update([
                'position' => $structure->position,
            ]);
            $structure->position = $position;
            $structure->updated_by = Auth::user()->id;
            $structure->save();

            return $structure;
        }
    }

    public function delete(int $id)
    {
        $structure = $this->find($id);
        $structure->delete();

        return $structure;
    }

    public function getSidaduApi($kodeUnit)
    {
        $client = new \GuzzleHttp\Client();

        $url = "https://sidadu.bppt.go.id/operator/webservice/website-bppt.php?kodeunit=".$kodeUnit;
        $response = $client->request('GET', $url, [

        ]);
        $data = $response->getBody()->getContents();
        $json = json_decode($data);

        return $json;
    }
}