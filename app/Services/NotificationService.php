<?php

namespace App\Services;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    private $model;

    public function __construct(
        Notification $model
    )
    {
        $this->model = $model;   
    }

    public function getNotificationList($request, $userId)
    {
        $query = $this->model->query();

        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('attribute->title', 'like', '%'.$q.'%')
                ->orWhere('attribute->content', 'like', '%'.$q.'%');
            });
        });
        $query->whereJsonContains('user_to', $userId);

        $limit = 20;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->orderBy('created_at', 'DESC')->paginate($limit);

        return $result;
    }

    public function latestNotification($userId)
    {
        $query = $this->model->query();

        $query->whereJsonContains('user_to', $userId);

        $result = $query->orderBy('created_at', 'DESC')
            ->limit(5)->get();

        return $result;
    }

    public function totalUnread($userId)
    {
        $query = $this->model->query();

        $query->whereJsonContains('user_to', $userId);
        $query->whereJsonDoesntContain('read_by', $userId);

        $result = $query->count();

        return $result;
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function send($from = null, $to, $attribute, $link)
    {
        $notification = new Notification;
        $notification->user_from = $from;
        $notification->user_to = $to;
        $notification->attribute = $attribute;
        $notification->link = $link;
        $notification->read_by = [0];
        $notification->save();

        return $notification;
    }

    public function read($userId, $id)
    {
        $find = $this->find($id);

        $readby = [];
        if(!empty($find->read_by)) {
            $readby = $find->read_by;
        }

        if(!in_array($userId, $readby)) {
            array_push($readby, $userId);
        }
        
        $find->update(['read_by' => $readby]);

        // $this->deleteIfAllRead($id);
    }

    public function deleteIfAllRead($id)
    {
        $find = $this->find($id);

        $read = $find->read_by;
        $sent = $find->user_to;

        dd($read, $sent);

        // if($read > $sent) {
        //     $find->delete();
        // }
    }
}