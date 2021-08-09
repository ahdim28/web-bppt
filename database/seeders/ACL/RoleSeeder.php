<?php

namespace Database\Seeders\ACL;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'super',
            'support',
            'admin',
        ];

        foreach ($roles as $val) {
            Role::create([
                'name' => $val,
                'guard_name' => 'web',
            ]);
        }
    }
}
