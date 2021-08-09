<?php

namespace App\Services\Users;

use App\Models\User;
use App\Models\UserLog;
use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserService
{
    private $model, $modelProfile, $modelLog;

    public function __construct(
        User $model,
        UserProfile $modelProfile,
        UserLog $modelLog
    )
    {
        $this->model = $model;
        $this->modelProfile = $modelProfile;
        $this->modelLog = $modelLog;
    }

    public function getUserList($request, $isTrash = false)
    {
        $query = $this->model->query();

        if ($isTrash == true) {
            $query->onlyTrashed();
        }

        //hide user dengan role super & support
        if (!Auth::user()->hasRole('super|support')) {
            $query->whereHas('roles', function ($query) {
                $query->whereNotIn('name', ['super', 'support']);
            });
        }

        $query->when($request->r, function ($query, $r) {
            return $query->whereHas('roles', function ($query) use ($r) {
                $query->where('id', $r);
            });
        })->when($request, function ($query, $req) {
            if ($req->a != '') {
                $query->where('active', $req->a);
            }
        })->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('name', 'like', '%'.$q.'%')
                ->orWhere('email', 'like', '%'.$q.'%')
                ->orWhere('username', 'like', '%'.$q.'%');
            });
        });
        $query->with('roles');

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

    public function getUserActive(array $byRole = null, $isVerif = true, 
        $cType = null, $cVal = null)
    {
        $query = $this->model->query();

        if (!empty($byRole)) {
            $query->whereHas('roles', function ($query) use ($byRole) {
                $query->whereIn('id', $byRole);
            });
        }

        $query->active();
        if ($isVerif == true) {
            $query->verified();
        }

        return $query->get();
    }

    public function getLog($request, $userId = null)
    {
        $query = $this->modelLog->query();

        if ($userId != null) {
            $query->where('user_id', $userId);
        }

        $query->when($request, function ($query, $req) {
            if ($req->e != '') {
                $query->where('event', $req->e);
            }
        })->when($request->q, function ($query, $q) {
            $query->where(function ($queryA) use ($q) {
                $queryA->whereHas('user', function (Builder $queryB) use ($q) {
                    $queryB->where('name', 'like', '%'.$q.'%');
                })->orWhere('ip_address', 'like', '%'.$q.'%')
                    ->orWhere('event_attr->description', 'like', '%'.$q.'%')
                    ->orWhere('logable_name', 'like', '%'.$q.'%');
            });
        });

        $limit = 20;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->orderBy('created_at', 'DESC')->paginate($limit);

        return $result;
    }

    public function count()
    {
        $query = $this->model->query();
        $query->active();

        $result = $query->count();

        return $result;
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function store($request, $role, $activate = true, $verified = false)
    {
        $user = new User($request->only(['name', 'email', 'username']));
        $user->password = Hash::make($request->password);

        if ($activate == true) {
            $user->active = (bool)$request->active;
            $user->active_at = ((bool)$request->active == 1) ? now() : null;
        }

        if ($activate == true) {
            $user->email_verified = (bool)$request->email_verified;
            $user->email_verified_at = ((bool)$request->email_verified_at == 1) ? now() : null;
        }

        // $user->phone = $request->phone ?? null;
        $user->profile_photo_path = [
            'filename' => null,
            'title' => null,
            'alt' => null,
        ];
        $user->assignRole($role);
        if (Auth::guard()->check() == true) {
            $user->created_by = Auth::user()->ixd;
        }
        $user->save();

        $this->updateOrCreateProfile($request, $user->id);

        return $user;
    }

    public function update($request, int $id)
    {
        $user = $this->find($id);
        $user->fill($request->only(['name', 'email', 'username']));

        if ($request->email != $request->old_email) {
            $user->email_verified = 0;
            $user->email_verified_at = null;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->active = (bool)$request->active;
        $user->active_at = ((bool)$request->active == 1) ? now() : null;
        // $user->phone = $request->phone ?? null;
        $user->assignRole($request->roles);
        $user->updated_by = Auth::user()->id;
        $user->save();

        return $user;
    }

    public function activate(int $id)
    {
        $user = $this->find($id);
        $user->active = !$user->active;
        $user->active_at = $user->active == 1 ? now() : null;
        $user->updated_by = Auth::user()->id;
        $user->save();

        return $user;
    }

    public function restore(int $id)
    {
        $user = $this->model->onlyTrashed()->where('id', $id);

        //restore data yang bersangkutan

        $user->restore();

        return $user;
    }

    public function trash(int $id)
    {
        $user = $this->find($id);
        $user->deleted_by = Auth::user()->id;
        $user->save();

        //hapus data yang bersangkutan

        $user->delete();

        return true;
    }

    public function delete($request, int $id)
    {
        if ($request->get('is_trash') == 'yes') {
            $user = $this->model->onlyTrashed()->where('id', $id)->first();
        } else {
            $user = $this->find($id);
        }

        if (!empty($user->profile_photo_path['filename'])) {
            Storage::delete(config('custom.files.avatars.path').
                $user->profile_photo_path['filename']);
        }

        //hapus data tabel tambahan jika ada user dengan role berbeda & memiliki tabel tersendiri

        $user->profile->delete();
        $user->forceDelete();

        return true;
    }

    public function logDelete(int $id)
    {
        $log = $this->modelLog->findOrFail($id);
        $log->delete();

        return $log;
    }

    /**
     * profile
     */
    public function updateOrCreateProfile($request, int $userId)
    {
        $profile = $this->modelProfile->updateOrCreate([
            'user_id' => $userId,
        ],
        [
            'user_id' => $userId,
            'gender' => ($request->gender != null) ? (bool)$request->gender : null,
            'place_of_birth' => $request->place_of_birth ?? null,
            'date_of_birth' => $request->date_of_birth ?? null,
            'address' => $request->address ?? null,
            'postal_code' => $request->postal_code ?? null,
            'phone' => $request->phone ?? null,
            'mobile_phone' => $request->mobile_phone ?? null,
            'socmed' => [
                'facebook' => $request->facebook ?? null,
                'instagram' => $request->instagram ?? null,
                'twitter' => $request->twitter ?? null,
                'pinterest' => $request->pinterest ?? null,
                'linkedin' => $request->linkedin ?? null,
            ],
        ]);

        return $profile;
    }

    public function updateProfile($request, int $id)
    {
        $user = $this->find($id);
        $user->fill($request->only(['name', 'email', 'username']));

        if ($request->email != $request->old_email) {
            $user->email_verified = 0;
            $user->email_verified_at = null;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        // $user->phone = $request->phone ?? null;
        $user->updated_by = Auth::user()->id;
        $user->save();

        $this->updateOrCreateProfile($request, Auth::user()->id);

        return $user;
    }

    public function changePhoto($request, int $id)
    {
        $user = $this->find($id);

        if ($request->hasFile('avatars')) {
            $file = $request->file('avatars');
            $name = Str::slug($user->name, '-');
            $fileName = $name.'.'.$file->getClientOriginalExtension();

            Storage::delete(config('custom.files.avatars.path').$request->old_avatars);
            Storage::put(config('custom.files.avatars.path').$fileName, file_get_contents($file));
        }

        $user->profile_photo_path = [
            'filename' => !empty($request->avatars) ? $fileName : 
                $user->profile_photo_path['filename'],
            'title' => $request->photo_title ?? null,
            'alt' => $request->photo_alt ?? null,
        ];

        $user->updated_by = Auth::user()->id;
        $user->save();

        return $user;
    }

    public function removePhoto($id)
    {
        $user = $this->find($id);

        Storage::delete(config('custom.files.avatars.path').
            $user->profile_photo_path['filename']);

        $user->profile_photo_path = [
            'filename' => null,
            'title' => $user->profile_photo_path['title'],
            'alt' => $user->profile_photo_path['alt'],
        ];

        $user->updated_by = Auth::user()->id;
        $user->save();

        return $user;
    }

    public function verificationEmail($email)
    {
        $decrypt = Crypt::decrypt($email);

        $user = $this->model->where('email', $decrypt)->first();
        $user->email_verified = 1;
        $user->email_verified_at = now();
        $user->save();

        return $user;
    }
}