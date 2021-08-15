<?php

namespace Database\Seeders\ACL;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class RoleHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Permission::all() as $val) {
            DB::table('role_has_permissions')->insert([
                'role_id' => 1,
                'permission_id' => $val->id
            ]);
        }

        $permissions = [1, 2, 3, 4, 9, 10, 11, 12, 17, 18, 19, 20, 21, 22, 23, 24, 
            25, 27, 29, 30, 31, 32, 33, 34, 35, 36, 57, 58, 59, 60, 61, 62, 63, 64, 
            65, 66, 67, 69, 71, 72, 74, 77, 78, 82, 84, 86, 87, 89, 90, 91, 92, 93, 94];

        foreach ($permissions as $val) {
            DB::table('role_has_permissions')->insert([
                'role_id' => 2,
                'permission_id' => $val
            ]);
        }

        foreach ($permissions as $val) {
            DB::table('role_has_permissions')->insert([
                'role_id' => 3,
                'permission_id' => $val
            ]);
        }
    }
}
