<?php

namespace App\Services;

use App\Models\Configuration;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ConfigurationService
{
    private $model;

    public function __construct(
        Configuration $model
    )
    {
        $this->model = $model;   
    }
    
    public function getConfig($group)
    {
        $query = $this->model->query();

        $query->where('group', $group)->where('is_upload', 0);

        $result = $query->get();

        return $result;
    }

    public function getConfigIsUpload()
    {
        $query = $this->model->query();

        $query->upload();

        $result = $query->get();

        return $result;
    }

    public function getValue($name)
    {
        return $this->model->value($name);
    }

    public function getFile($name)
    {
        $config = $this->model->select('value')->where('name', $name)->first();

        if (!empty($config->value)) {
            $file = Storage::url(config('custom.files.config.path').$config->value);
        } else {
            $file = asset(config('custom.files.config.'.$name.'.file'));
        }

        return $file;
    }

    public function updateConfig($name, $value)
    {
        $config = $this->model->where('name', $name)->first();
        $config->value = $value;
        $config->save();

        return $config;
    }

    public function uploadFile($request, $name)
    {
        if ($request->hasFile($name)) {

            if ($name == 'google_analytics_api') {

                $fileName = 'service-account-credentials.'.
                $request->google_analytics_api->getClientOriginalExtension();
                $request->file('google_analytics_api')->move(storage_path('app/analytics'), $fileName);

            } else {

                $file = $request->file($name);
                $fileName = Str::replace(' ', '-', $file->getClientOriginalName());

                Storage::delete(config('custom.files.config.path').$request->input('old_'.$name));
                Storage::put(config('custom.files.config.path').$fileName, file_get_contents($file));
            }

            $config = $this->model->where('name', $name)->first();
            $config->value = $fileName;
            $config->save();

            return $config;

        } else {

            return false;
            
        }
    }
}