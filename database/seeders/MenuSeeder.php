<?php

namespace Database\Seeders;

use App\Models\Menu\Menu;
use App\Models\Menu\MenuCategory;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = [
            'Header',
            'Quick Links',
        ];

        foreach ($category as $val) {
            
            MenuCategory::create([
                'name' => $val,
                'created_by' => 1,
                'updated_by' => 1,
            ]);
        }

        //-- menu --//
        $menu = [
            0 => [
                'menu_category_id' => 1,
                'parent' => 0,
                'title' => [
                    'id' => 'Beranda',
                    'en' => 'Home'
                ],
                'module' => null,
                'attr' => [
                    'url' => '/',
                    'target_blank' => false,
                    'not_from_module' => true,
                ],
                'publish' => 0,
                'public' => 1,
                'edit_public_menu' => 1,
                'menuable_id' => null,
                'menuable_type' => null,
                'position' => 1,
            ],
        ];

        foreach ($menu as $val) {
            
            Menu::create([
                'menu_category_id' => $val['menu_category_id'],
                'parent' => $val['parent'],
                'title' => $val['title'],
                'module' => $val['module'],
                'attr' => $val['attr'],
                'publish' => $val['publish'],
                'public' => $val['public'],
                'edit_public_menu' => $val['edit_public_menu'],
                'menuable_id' => $val['menuable_id'],
                'menuable_type' => $val['menuable_type'],
                'position' => $val['position'],
                'created_by' => 1,
                'updated_by' => 1,
            ]);
        }
    }
}
