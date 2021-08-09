<?php

namespace App\Observers;

use App\Models\UserLog;
use Illuminate\Support\Facades\Auth;

class LogObserver
{
    public function saved($model)
    {
        $log = new UserLog();
        $data = $log->logable()->associate($model);

        if ($model->wasRecentlyCreated == true) {
            $event = 'create';
            $desc = 'added new data in the <strong><span class="badge badge-secondary">'.
                str_replace('_', ' ', strtoupper($model->getTable())).'
                 ('.$data['logable_id'].')</span></strong> module';
            $icon = 'ion-md-add bg-success';
            $color = 'success';
        } else {
            $event = 'update';
            $desc = 'edit data in the <strong><span class="badge badge-secondary">'.
            str_replace('_', ' ', strtoupper($model->getTable())).'
             ('.$data['logable_id'].')</span></strong> module';
            $icon = 'ion-md-create bg-primary';
            $color = 'primary';
        }

        if (Auth::check() == true) {
            UserLog::create([
                'user_id' => Auth::user()->id,
                'event' => $event,
                'event_attr' => [
                    'description' => $desc,
                    'icon' => $icon,
                    'color' => $color,
                ],
                'logable_id' => $data['logable_id'],
                'logable_type' => $data['logable_type'],
                'logable_name' => $model->getTable(),
                'ip_address' => request()->ip(),
            ]);
        }
    }

    public function deleting($model)
    {
        $log = new UserLog;
        $data = $log->logable()->associate($model);

        if (Auth::check() == true) {
            UserLog::create([
                'user_id' => Auth::user()->id,
                'event' => 'delete',
                'event_attr' => [
                    'description' => 'delete data in the <strong><span class="badge badge-secondary">'.
                    str_replace('_', ' ', strtoupper($model->getTable())).'
                     ('.$data['logable_id'].')</span></strong> module',
                    'icon' => 'ion ion-md-trash bg-danger',
                    'color' => 'danger',
                ],
                'logable_id' => $data['logable_id'],
                'logable_type' => $data['logable_type'],
                'logable_name' => $model->getTable(),
                'ip_address' => request()->ip(),
            ]);
        }
    }
}
