<?php

namespace Database\Seeders;

use App\Models\Master\Template;
use Illuminate\Database\Seeder;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //--template--//
        $templates = [
            0 => [
                'name' => 'Content With Cover',
                'module' => 0,
                'type' => 0,
                'file_path' => 'views/frontend/pages/custom/content-with-cover',
            ],
            1 => [
                'name' => 'Content With Media',
                'module' => 0,
                'type' => 0,
                'file_path' => 'views/frontend/pages/custom/content-with-media',
            ],
            2 => [
                'name' => 'Content Structure Organization',
                'module' => 2,
                'type' => 1,
                'file_path' => 'views/frontend/content/categories/list/content-structur-organization',
            ],
        ];

        foreach ($templates as $val) {
            Template::create([
                'name' => $val['name'],
                'module' => $val['module'],
                'type' => $val['type'],
                'file_path' => $val['file_path'],
                'created_by' => 1,
                'updated_by' => 1,
            ]);
        }
    }
}
