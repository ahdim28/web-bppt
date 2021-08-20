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
                'name' => 'Pengantar',
                'module' => 0,
                'type' => 0,
                'file_path' => 'views/frontend/pages/custom/pengantar',
            ],
            1 => [
                'name' => 'Sejarah',
                'module' => 0,
                'type' => 0,
                'file_path' => 'views/frontend/pages/custom/sejarah',
            ],
            2 => [
                'name' => 'Siaran Pers',
                'module' => 1,
                'type' => 1,
                'file_path' => 'views/frontend/content/sections/list/siaran-pers',
            ],
            3 => [
                'name' => 'Detail Event',
                'module' => 1,
                'type' => 2,
                'file_path' => 'views/frontend/content/sections/detail/event',
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
