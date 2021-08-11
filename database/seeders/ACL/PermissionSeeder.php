<?php

namespace Database\Seeders\ACL;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            0 => [
                'parent' => 0,
                'name' => 'users'
            ],
            1 => [
                'parent' => 1,
                'name' => 'user_create'
            ],
            2 => [
                'parent' => 1,
                'name' => 'user_update'
            ],
            3 => [
                'parent' => 1,
                'name' => 'user_delete'
            ],
            4 => [
                'parent' => 0,
                'name' => 'fields'
            ],
            5 => [
                'parent' => 5,
                'name' => 'field_create'
            ],
            6 => [
                'parent' => 5,
                'name' => 'field_update'
            ],
            7 => [
                'parent' => 5,
                'name' => 'field_delete'
            ],
            8 => [
                'parent' => 0,
                'name' => 'tags'
            ],
            9 => [
                'parent' => 9,
                'name' => 'tag_create'
            ],
            10 => [
                'parent' => 9,
                'name' => 'tag_update'
            ],
            11 => [
                'parent' => 9,
                'name' => 'tag_delete'
            ],
            12 => [
                'parent' => 0,
                'name' => 'comments'
            ],
            13 => [
                'parent' => 13,
                'name' => 'comment_create'
            ],
            14 => [
                'parent' => 13,
                'name' => 'comment_update'
            ],
            15 => [
                'parent' => 13,
                'name' => 'comment_delete'
            ],
            16 => [
                'parent' => 0,
                'name' => 'medias'
            ],
            17 => [
                'parent' => 17,
                'name' => 'media_create'
            ],
            18 => [
                'parent' => 17,
                'name' => 'media_update'
            ],
            19 => [
                'parent' => 17,
                'name' => 'media_delete'
            ],
            20 => [
                'parent' => 0,
                'name' => 'pages'
            ],
            21 => [
                'parent' => 21,
                'name' => 'page_create'
            ],
            22 => [
                'parent' => 21,
                'name' => 'page_update'
            ],
            23 => [
                'parent' => 21,
                'name' => 'page_delete'
            ],
            24 => [
                'parent' => 0,
                'name' => 'content_sections'
            ],
            25 => [
                'parent' => 25,
                'name' => 'content_section_create'
            ],
            26 => [
                'parent' => 25,
                'name' => 'content_section_update'
            ],
            27 => [
                'parent' => 25,
                'name' => 'content_section_delete'
            ],
            28 => [
                'parent' => 0,
                'name' => 'content_categories'
            ],
            29 => [
                'parent' => 29,
                'name' => 'content_category_create'
            ],
            30 => [
                'parent' => 29,
                'name' => 'content_category_update'
            ],
            31 => [
                'parent' => 29,
                'name' => 'content_category_delete'
            ],
            32 => [
                'parent' => 0,
                'name' => 'content_posts'
            ],
            33 => [
                'parent' => 33,
                'name' => 'content_post_create'
            ],
            34 => [
                'parent' => 33,
                'name' => 'content_post_update'
            ],
            35 => [
                'parent' => 33,
                'name' => 'content_post_delete'
            ],
            36 => [
                'parent' => 0,
                'name' => 'banner_categories'
            ],
            37 => [
                'parent' => 37,
                'name' => 'banner_category_create'
            ],
            38 => [
                'parent' => 37,
                'name' => 'banner_category_update'
            ],
            39 => [
                'parent' => 37,
                'name' => 'banner_category_delete'
            ],
            40 => [
                'parent' => 0,
                'name' => 'banners'
            ],
            41 => [
                'parent' => 41,
                'name' => 'banner_create'
            ],
            42 => [
                'parent' => 41,
                'name' => 'banner_update'
            ],
            43 => [
                'parent' => 41,
                'name' => 'banner_delete'
            ],
            44 => [
                'parent' => 0,
                'name' => 'catalog_types'
            ],
            45 => [
                'parent' => 45,
                'name' => 'catalog_type_create'
            ],
            46 => [
                'parent' => 45,
                'name' => 'catalog_type_update'
            ],
            47 => [
                'parent' => 45,
                'name' => 'catalog_type_delete'
            ],
            48 => [
                'parent' => 0,
                'name' => 'catalog_categories'
            ],
            49 => [
                'parent' => 49,
                'name' => 'catalog_category_create'
            ],
            50 => [
                'parent' => 49,
                'name' => 'catalog_category_update'
            ],
            51 => [
                'parent' => 49,
                'name' => 'catalog_category_delete'
            ],
            52 => [
                'parent' => 0,
                'name' => 'catalog_products'
            ],
            53 => [
                'parent' => 53,
                'name' => 'catalog_product_create'
            ],
            54 => [
                'parent' => 53,
                'name' => 'catalog_product_update'
            ],
            55 => [
                'parent' => 53,
                'name' => 'catalog_product_delete'
            ],
            56 => [
                'parent' => 0,
                'name' => 'albums'
            ],
            57 => [
                'parent' => 57,
                'name' => 'album_create'
            ],
            58 => [
                'parent' => 57,
                'name' => 'album_update'
            ],
            59 => [
                'parent' => 57,
                'name' => 'album_delete'
            ],
            60 => [
                'parent' => 57,
                'name' => 'photos'
            ],
            61 => [
                'parent' => 0,
                'name' => 'playlists'
            ],
            62 => [
                'parent' => 62,
                'name' => 'playlist_create'
            ],
            63 => [
                'parent' => 62,
                'name' => 'playlist_update'
            ],
            64 => [
                'parent' => 62,
                'name' => 'playlist_delete'
            ],
            65 => [
                'parent' => 62,
                'name' => 'videos'
            ],
            66 => [
                'parent' => 0,
                'name' => 'links'
            ],
            67 => [
                'parent' => 67,
                'name' => 'link_create'
            ],
            68 => [
                'parent' => 67,
                'name' => 'link_update'
            ],
            69 => [
                'parent' => 67,
                'name' => 'link_delete'
            ],
            70 => [
                'parent' => 67,
                'name' => 'link_medias'
            ],
            71 => [
                'parent' => 0,
                'name' => 'inquiries'
            ],
            72 => [
                'parent' => 72,
                'name' => 'inquiry_create'
            ],
            73 => [
                'parent' => 72,
                'name' => 'inquiry_update'
            ],
            74 => [
                'parent' => 72,
                'name' => 'inquiry_delete'
            ],
            75 => [
                'parent' => 72,
                'name' => 'inquiry_field'
            ],
            76 => [
                'parent' => 72,
                'name' => 'inquiry_detail'
            ],
            77 => [
                'parent' => 0,
                'name' => 'menu_categories'
            ],
            78 => [
                'parent' => 78,
                'name' => 'menu_category_create'
            ],
            79 => [
                'parent' => 78,
                'name' => 'menu_category_update'
            ],
            80 => [
                'parent' => 78,
                'name' => 'menu_category_delete'
            ],
            81 => [
                'parent' => 0,
                'name' => 'menus'
            ],
            82 => [
                'parent' => 82,
                'name' => 'menu_create'
            ],
            83 => [
                'parent' => 82,
                'name' => 'menu_update'
            ],
            84 => [
                'parent' => 82,
                'name' => 'menu_delete'
            ],
            85 => [
                'parent' => 0,
                'name' => 'visitor'
            ],
            86 => [
                'parent' => 0,
                'name' => 'filemanager'
            ],
            87 => [
                'parent' => 0,
                'name' => 'backup'
            ],
            88 => [
                'parent' => 0,
                'name' => 'configurations'
            ],
            89 => [
                'parent' => 0,
                'name' => 'commons'
            ],
            90 => [
                'parent' => 0,
                'name' => 'structures'
            ],
            91 => [
                'parent' => 91,
                'name' => 'structure_create'
            ],
            92 => [
                'parent' => 91,
                'name' => 'structure_update'
            ],
            93 => [
                'parent' => 91,
                'name' => 'structure_delete'
            ],
        ];

        foreach ($permissions as $val) {
            Permission::create([
                'parent' => $val['parent'],
                'name' => $val['name'],
                'guard_name' => 'web',
            ]);
        }
    }
}
