<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginFrontendRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    private $service;

    use ValidatesRequests;

    public function __construct(
        AuthService $service
    )
    {
        $this->service = $service;
    }

    /**
     * login for backend
     */
    public function showLoginForm()
    {
        if (config('custom.setting.module.auth.login') == false) {
            return abort(404);
        }

        return view('auth.login', [
            'title' => __('auth.login.title')
        ]);
    }

    public function login(LoginRequest $request)
    {
        if (config('custom.setting.module.auth.login') == false) {
            return abort(404);
        }

        $login = $this->service->login($request);

        if ($login == true) {
            return redirect()->route('dashboard')
                ->with('success', __('auth.login.alert.success'));
        } else {
            return back()->with('failed', __('auth.login.alert.failed'));
        }
    }

    public function logout()
    {
        if (config('custom.setting.module.auth.login') == false) {
            return abort(404);
        }

        $this->service->logout();
       
        return redirect()->route('login')
            ->with('success', __('auth.logout.alert.success'));
    }

    /**
     * login for frontend
     */
    public function showLoginFrontendForm()
    {
        if (config('custom.setting.module.auth.login_frontend') == false) {
            return abort(404);
        }

        return view('auth.login-frontend', [
            'title' => __('auth.login_frontend.title')
        ]);
    }

    public function loginFrontend(LoginFrontendRequest $request)
    {
        if (config('custom.setting.module.auth.login_frontend') == false) {
            return abort(404);
        }

        $login = $this->service->loginFrontend($request);

        if ($login == true) {
            return redirect()->route('home')
                ->with('success', __('auth.login_frontend.alert.success'));
        } else {
            return back()->with('failed', __('auth.login_frontend.alert.failed'));
        }
    }

    public function logoutFrontend()
    {
        if (config('custom.setting.module.auth.login_frontend') == false) {
            return abort(404);
        }
        
        $this->service->logout();
       
        return redirect()->route('login.frontend')
            ->with('success', __('auth.logout_frontend.alert.success'));
    }
}
