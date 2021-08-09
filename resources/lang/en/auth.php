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

    'back_home' => 'Back to Home',
    
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
            'field1' => 'Enter your username...',
            'field2' => 'Enter your password...',
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
        'text' => 'Login to Your Account',
        'label' => [
            'field1' => 'Username',
            'field2' => 'Password',
            'field3' => 'Remember me',
        ],
        'placeholder' => [
            'field1' => 'Enter your username...',
            'field2' => 'Enter your password...',
        ],
        'signin_caption' => 'Log In',
        'forgot_password' => 'Forgot Password?',
        'signup_text' => 'Don\'t have an account yet?',
        'signup_btn' => 'Sign Up',
        'alert' => [
            'exists' => 'The Account you are trying to login is not registered or it has been disabled',
            'success' => 'Login successfully',
            'failed' => 'Username / Password wrong, please try again !'
        ]
    ],
    //logout
    'logout' => [
        'title' => 'Log Out',
        'alert' => [
            'success' => 'Logout successfully'
        ],
    ],
    'logout_user' => [
        'title' => 'Log Out',
        'alert' => [
            'success' => 'Logout successfully'
        ],
    ],
    //forgot password
    'forgot_password' => [
        'title' => 'Forgot Password',
        'text' => 'Enter your email address and we will send you a link to reset your password.',
        'back_login' => 'Back to login',
        'label' => [
            'field1' => 'Email',
        ],
        'placeholder' => [
            'field1' => 'Enter your email',
        ],
        'send_caption' => 'Send password reset email',
    ],
    //reset password
    'reset_password' => [
        'title' => 'Reset Password',
        'text' => 'Reset Password',
        'label' => [
            'field1' => 'New Password',
            'field2' => 'Repeat New Password',
        ],
        'placeholder' => [
            'field1' => 'Enter your new password...',
            'field2' => 'Enter repeat new password...',
        ],
        'reset_caption' => 'Reset Password',
    ],
    //register
    'register' => [
        'title' => 'Register',
        'text' => 'Register New Account',
        'label' => [
            'field1' => 'Name',
            'field2' => 'Email',
            'field3' => 'Username',
            'field4' => 'Password',
            'field5' => 'Repeat Password',
        ],
        'placeholder' => [
            'field1' => 'Enter your name...',
            'field2' => 'Enter your email...',
            'field3' => 'Enter your username...',
            'field4' => 'Enter your password...',
            'field5' => 'Repeat password...',
        ],
        'signup_caption' => 'Sign Up',
        'already_account' => 'Already have an account?',
        'mailing' => [
            'title' => 'Activate account',
            'text' => 'Click the button below to activate your account:',
            'btn_activate' => 'ACTIVATE',
        ],
        'alert' => [
            'success' => 'Register successfully, check your email for activate your account',
            'info_active' => 'Your account is active now, please login',
        ],
    ],
];
