<?php

return [
    //untuk mengaktifkan permalink short
    'index_url' => true,
    //untuk mengaktifkan auto redirect ke ISO CODE bahasa
    'locales' => true,
    //untuk sortir module mana yang akan dipakai, juga untuk sitemap
    'module' => [
        'auth' => [
            'login' => true,
            'login_frontend' => false,
            'forgot_password' => false,
            'register' => false,
        ],
        'page' => true,
        'section' => true,
        'category' => true,
        'post' => true,
        'banner' => true,
        'catalog' => false,
        'album' => true,
        'playlist' => true,
        'link' => true,
        'inquiry' => true,
    ]
];