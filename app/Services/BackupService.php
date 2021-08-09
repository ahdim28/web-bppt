<?php

namespace App\Services;

use App\Models\Backup;

class BackupService
{
    private $model;

    public function __construct(
        Backup $model
    )
    {
        $this->model = $model;
    }

    public function getBackupList($request)
    {
        $query = $this->model->query();

        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('file_path', 'like', '%'.$q.'%');
            });
        });

        $limit = 20;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->orderBy('backup_date', 'DESC')->paginate($limit);

        return $result;
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function backup($filePath, $status)
    {
        $backup = new Backup;
        $backup->backup_date = now()->format('Y-m-d');
        $backup->file_path = $filePath;
        $backup->status = $status;
        $backup->save();

        return $backup;
    }
}