<?php

namespace Database\Seeders;

use App\Models\IndexUrl;
use Illuminate\Database\Seeder;
use PhpParser\Node\Stmt\Foreach_;

class IndexUrlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $indexing = [
            0 => [
                'slug' => 'backend',
                'id' => null,
                'type' => null,
            ],
            1 => [
                'slug' => 'admin',
                'id' => null,
                'type' => null,
            ],
            2 => [
                'slug' => 'login',
                'id' => null,
                'type' => null,
            ],
            3 => [
                'slug' => 'sign-in',
                'id' => null,
                'type' => null,
            ],
            4 => [
                'slug' => 'register',
                'id' => null,
                'type' => null,
            ],
            5 => [
                'slug' => 'sign-up',
                'id' => null,
                'type' => null,
            ],
            6 => [
                'slug' => 'forgot-password',
                'id' => null,
                'type' => null,
            ],
            7 => [
                'slug' => 'reset-password',
                'id' => null,
                'type' => null,
            ],
            8 => [
                'slug' => 'maintenance',
                'id' => null,
                'type' => null,
            ],
            9 => [
                'slug' => 'feed',
                'id' => null,
                'type' => null,
            ],
            10 => [
                'slug' => 'landing',
                'id' => null,
                'type' => null,
            ],
            11 => [
                'slug' => 'search',
                'id' => null,
                'type' => null,
            ],
            12 => [
                'slug' => 'page',
                'id' => null,
                'type' => null,
            ],
            13 => [
                'slug' => 'section',
                'id' => null,
                'type' => null,
            ],
            14 => [
                'slug' => 'category',
                'id' => null,
                'type' => null,
            ],
            15 => [
                'slug' => 'post',
                'id' => null,
                'type' => null,
            ],
            16 => [
                'slug' => 'catalog',
                'id' => null,
                'type' => null,
            ],
            17 => [
                'slug' => 'gallery',
                'id' => null,
                'type' => null,
            ],
            18 => [
                'slug' => 'album',
                'id' => null,
                'type' => null,
            ],
            19 => [
                'slug' => 'playlist',
                'id' => null,
                'type' => null,
            ],
            20 => [
                'slug' => 'link',
                'id' => null,
                'type' => null,
            ],
            21 => [
                'slug' => 'inquiry',
                'id' => null,
                'type' => null,
            ],
            22 => [
                'slug' => config('custom.language.default'),
                'id' => null,
                'type' => null,
            ],
            23 => [
                'slug' => 'kontak',
                'id' => 1,
                'type' => 'App\Models\Inquiry\Inquiry',
            ],
            24 => [
                'slug' => 'structure-organization',
                'id' => null,
                'type' => null,
            ],
        ];

        foreach ($indexing as $value) {
            
            IndexUrl::create([
                'slug' => $value['slug'],
                'urlable_id' => $value['id'],
                'urlable_type' => $value['type'],
            ]);
        }
    }
}
