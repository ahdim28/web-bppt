<?php

namespace App\Services\Master;

use App\Models\Master\Template;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TemplateService
{
    private $model;

    public function __construct(
        Template $model
    )
    {
        $this->model = $model;
    }

    public function getTemplateList($request)
    {
        $query = $this->model->query();

        $query->when($request->m, function ($query, $m) {
            $query->where('module', $m);
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

    public function getTemplate($module, $type = 0)
    {
        $query = $this->model->query();

        $query->where('module', $module)->where('type', $type);

        $result = $query->get();

        return $result;
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function store($request)
    {
        if ($request->module == 1 || $request->module == 2) {
            $type = ($request->type == 0) ? 1 : $request->type;
        } else {
            $type = ($request->type > 0) ? 0 : $request->type;
        }

        $template = new Template;
        $template->name = $request->name;
        $template->module = $request->module;
        $template->type = $type;
        $template->file_path = Str::replace('.blade.php', '', 
            $this->checkModule($request, $type, $request->module));
        $template->created_by = Auth::user()->id;
        $template->save();

        return $template;
    }

    public function update($request, int $id)
    {
        $template = $this->find($id);
        $template->name = $request->name;
        $template->updated_by = Auth::user()->id;
        $template->save();

        return $template;
    }

    public function checkModule($request, $type, $module)
    {
        $templateType = config('custom.templates.type.'.$type);
        $templateModule = config('custom.templates.module.'.$module);
        $resource = config('custom.templates.path.'.$templateModule);

        $filePath = $resource['full'].$resource[$templateType].'/'.
            Str::slug($request->filename, '-').'.blade.php';

        if (!file_exists(resource_path($filePath))) {

            File::makeDirectory(resource_path($resource['full'].
                $resource[$templateType]), $mode = 0777, true, true);
            $path = resource_path($filePath);
            File::put($path, '');
        }

        return $filePath;
    }

    public function delete(int $id)
    {
        $template = $this->find($id);

        $page = $template->pages->count();
        $sectionList = $template->sectionList->count();
        $sectionDetail = $template->sectionDetail->count();
        $categoryList =  $template->categoryList->count();
        $categorDetail = $template->categoryDetail->count();
        $post = $template->posts->count();
        $catalogCategory = $template->catalogCategories->count();
        $catalogProduct = $template->catalogProducts->count();
        $album = $template->albums->count();
        $playlist = $template->playlists->count();
        $link = $template->links->count();

        if ($page == 0 && $sectionList == 0 && $sectionDetail == 0 && $categoryList == 0 &&
            $categorDetail == 0 && $post == 0 && $catalogCategory == 0 && $catalogProduct == 0 &&
            $album == 0 && $playlist == 0 && $link == 0) {
            
                $path = resource_path($template->file_path.'.blade.php');
                File::delete($path);
        
                $template->delete();
                return true;

        } else {
            return false;
        }
    }
}