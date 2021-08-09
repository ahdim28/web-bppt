<?php

return [
    'module' => [
        0 => 'pages',
        1 => 'sections',
        2 => 'categories',
        3 => 'posts',
        4 => 'catalog_categories',
        5 => 'catalog_products',
        6 => 'albums',
        7 => 'playlists',
        8 => 'links',
    ],
    'type' => [
        0 => 'custom',
        1 => 'list',
        2 => 'detail',
    ],
    'path' => [
        'pages' => [
            'full' => 'views/frontend/pages/',
            'custom' => 'custom',
        ],
        'sections' => [
            'full' => 'views/frontend/content/sections/',
            'list' => 'list',
            'detail' => 'detail',
        ],
        'categories' => [
            'full' => 'views/frontend/content/categories/',
            'list' => 'list',
            'detail' => 'detail',
        ],
        'posts' => [
            'full' => 'views/frontend/content/posts/',
            'custom' => 'custom',
        ],
        'catalog_categories' => [
            'full' => 'views/frontend/catalog/categories/',
            'custom' => 'custom',
        ],
        'catalog_products' => [
            'full' => 'views/frontend/catalog/products/',
            'custom' => 'custom',
        ],
        'albums' => [
            'full' => 'views/frontend/gallery/albums/',
            'custom' => 'custom',
        ],
        'playlists' => [
            'full' => 'views/frontend/gallery/playlists/',
            'custom' => 'custom',
        ],
        'links' => [
            'full' => 'views/frontend/links/',
            'custom' => 'custom',
        ],
    ],
];