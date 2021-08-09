<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            0 => [
                'name' => 'Developer 4VM',
                'email' => 'developer@4visionmedia.com',
                'email_verified' => 1,
                'email_verified_at' => now(),
                'username' => '4vmSuper',
                'password' => Hash::make('bpptSup3r#'),
                'active' => 1,
                'active_at' => now(),
                'roles' => 'super',
            ],
            1 => [
                'name' => 'Support 4VM',
                'email' => 'support@4visionmedia.com',
                'email_verified' => 1,
                'email_verified_at' => now(),
                'username' => '4vmSupport',
                'password' => Hash::make('bpptSupp0rt#'),
                'active' => 1,
                'active_at' => now(),
                'roles' => 'support',
            ],
            2 => [
                'name' => 'Client',
                'email' => 'client@gmail.com',
                'email_verified' => 0,
                'email_verified_at' => null,
                'username' => 'admweb',
                'password' => Hash::make('bppT'.now()->format('Y').'#'),
                'active' => 1,
                'active_at' => now(),
                'roles' => 'admin',
            ],
        ];

        foreach ($users as $val) {
            
            $user = User::create([
                'name' => $val['name'],
                'email' => $val['email'],
                'email_verified' => $val['email_verified'],
                'email_verified_at' => $val['email_verified_at'],
                'username' => $val['username'],
                'password' => $val['password'],
                'active' => $val['active'],
                'active_at' => $val['active_at'],
                'profile_photo_path' => [
                    'filename' => null,
                    'title' => null,
                    'alt' => null,
                ],
            ]);

            $profile = UserProfile::create([
                'user_id' => $user->id,
                'socmed' => [
                    'facebook' => null,
                    'instagram' => null,
                    'twitter' => null,
                    'pinterest' => null,
                    'linkedin' => null,
                ],
            ]);

            $user->assignRole($val['roles']);
        }
    }
}
