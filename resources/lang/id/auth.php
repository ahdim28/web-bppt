<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',

    'back_home' => 'Kembali ke beranda',

    //login
    'login' => [
        'title' => 'Authentication required',
        'text' => 'Login to Your Account',
        'label' => [
            'field1' => 'Username',
            'field2' => 'Password',
            'field3' => 'Remember me',
        ],
        'placeholder' => [
            'field1' => 'Enter username...',
            'field2' => 'Enter password...',
        ],
        'signin_caption' => 'Sign In',
        'alert' => [
            'exists' => 'The Account you are trying to login is not registered or it has been disabled',
            'success' => 'Login successfully',
            'failed' => 'Username / Password wrong, please try again !'
        ]
    ],
    //login frontend
    'login_frontend' => [
        'title' => 'Login',
        'text' => 'Login ke Akun Anda',
        'label' => [
            'field1' => 'Username',
            'field2' => 'Password',
            'field3' => 'Ingat Saya',
        ],
        'placeholder' => [
            'field1' => 'Username...',
            'field2' => 'Password...',
        ],
        'signin_caption' => 'Log In',
        'forgot_password' => 'Lupa Password?',
        'signup_text' => 'Belum memiliki akun?',
        'signup_btn' => 'Daftar disini',
        'alert' => [
            'exists' => 'Akun yang coba anda masukan tidak terdaftar / tidak aktif',
            'success' => 'Login berhasil',
            'failed' => 'Username / Password salah, coba lagi !'
        ]
    ],
    //logout
    'logout' => [
        'title' => 'Log Out',
        'alert' => [
            'success' => 'Logout successfully'
        ],
    ],
    'logout_frontend' => [
        'title' => 'Log Out',
        'alert' => [
            'success' => 'Logout berhasil'
        ],
    ],
    //register
    'register' => [
        'title' => 'Register',
        'text' => 'Register Akun Baru',
        'label' => [
            'field1' => 'Name',
            'field2' => 'Email',
            'field3' => 'Username',
            'field4' => 'Password',
            'field5' => 'Konfirmasi Password',
        ],
        'placeholder' => [
            'field1' => 'Nama...',
            'field2' => 'Email...',
            'field3' => 'Username...',
            'field4' => 'Password...',
            'field5' => 'Konfirmasi Password...',
        ],
        'signup_caption' => 'Daftar',
        'already_account' => 'Sudah memiliki akun?',
        'mailing' => [
            'title' => 'Aktivasi Akun',
            'text' => 'Klik tombol di bawah ini untuk mengaktifkan akun Anda:',
            'btn_activate' => 'AKTIVASI',
        ],
        'alert' => [
            'success' => 'Daftar berhasil, periksa email Anda untuk mengaktifkan akun Anda',
            'failed' => 'Daftar gagal, cek kembali data yang anda masukan',
            'info_active' => 'Akun Anda aktif sekarang, silakan login',
        ],
    ],
    //forgot password
    'forgot_password' => [
        'title' => 'Lupa Password',
        'text' => 'Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mereset kata sandi Anda',
        'back_login' => 'Kembali ke login',
        'label' => [
            'field1' => 'Email',
        ],
        'placeholder' => [
            'field1' => 'Masukan email...',
        ],
        'send_caption' => 'Kirim link reset password',
    ],
    //reset password
    'reset_password' => [
        'title' => 'Reset Password',
        'text' => 'Reset Password',
        'label' => [
            'field1' => 'Password Baru',
            'field2' => 'Konfirmasi Password Baru',
        ],
        'placeholder' => [
            'field1' => 'Enter your new password...',
            'field2' => 'Enter repeat new password...',
        ],
        'reset_caption' => 'Reset Password',
    ],
];
