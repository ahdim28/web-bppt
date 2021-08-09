<?php

namespace App\Services;

use App\Models\User;
use App\Services\Users\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class AuthService
{
    private $modelUser, $user;

    public function __construct(
        User $modelUser,
        UserService $user
    )
    {
        $this->modelUser = $modelUser;
        $this->user = $user;
    }

    /**
     * login
     */
    public function login($request)
    {
        $checkRole = $this->modelUser->where('username', $request->username)->first();

        //cek role apa saja yang bisa login di backend
        if ($checkRole->hasRole('super|support|admin')) {
           
            $remember = $request->has('remember') ? true : false;
            if (Auth::attempt($request->forms(), $remember)) {
                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    public function loginFrontend($request)
    {
        $checkRole = $this->modelUser->where('username', $request->username)->first();

        //cek role apa saja yang bisa login di frontend
        if ($checkRole->hasRole('role_name')) {

            $remember = $request->has('remember') ? true : false;
            if (Auth::attempt($request->forms(), $remember)) {
                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();

        return true;
    }

    /**
     * register
     * jika register relasi dengan tabel lain, cek input menggunakan DB::transaction
     */
    public function register($request, $role)
    {
        //check unique data
        $email = $this->modelUser->where('email', $request->email)->count();
        $username = $this->modelUser->where('username', $request->username)->count();

        if ($email == 0 && $username == 0) {

            //default regsiter
            $user = $this->user->store($request, $role, false, false);
            return true;

        } else {
            return false;
        }
    }

    public function activateAccount($email)
    {
        $decrypt = Crypt::decrypt($email);

        $user = $this->modelUser->where('email', $decrypt)->first();
        $user->active = 1;
        $user->active_at = now();
        $user->email_verified = 1;
        $user->email_verified_at = now();
        $user->save();

        return $user;
    }
}