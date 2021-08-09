<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    private $service;

    public function __construct(
        AuthService $service
    )
    {
        $this->service = $service;
    }

    public function showRegisterForm()
    {
        if (config('custom.setting.module.auth.register') == false) {
            return abort(404);
        }

        return view('auth.register', [
            'title' => __('auth.register.title')
        ]);
    }

    public function register(RegisterRequest $request)
    {
        if (config('custom.setting.module.auth.register') == false) {
            return abort(404);
        }
        
        $register = $this->service->register($request, $request->roles);

        if ($register == true) {
            
            $encrypt = Crypt::encrypt($request->email);

            $data = [
                'title' => __('auth.register.mailing.title'),
                'email' => $request->email,
                'link' => route('register.activate', ['email' => $encrypt]),
            ];

            if (config('custom.notification.email.activation') == true) {
                Mail::to($request->email)->send(new \App\Mail\ActivateAccountMail($data));
            }

            return redirect()->route('login.frontend')->with('success', 
                __('auth.register.alert.success'));

        } else {
            return redirect()->route('login.frontend')->with('failed', 
                __('auth.register.alert.failed'));
        }
    }

    public function activate($email)
    {
        if (config('custom.setting.module.auth.register') == false) {
            return abort(404);
        }

        $this->service->activateAccount($email);

        return redirect()->route('login.frontend')->with('info', 
            __('auth.register.alert.info_active'));
    }
}
