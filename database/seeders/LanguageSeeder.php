<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $language = [
            0 => [
                'iso_codes' => 'id',
                'country' => 'Indonesia',
                'faker_locale' => 'id_ID',
                'time_zone' => 'Asia/Jakarta',
                'country_code' => 62,
                'status' => 1,
            ],
            1 => [
                'iso_codes' => 'en',
                'country' => 'English',
                'faker_locale' => 'en_US',
                'time_zone' => 'UTC',
                'country_code' => null,
                'status' => 1,
            ],
        ];

        foreach ($language as $val) {
            
            Language::create([
                'iso_codes' => $val['iso_codes'],
                'country' => $val['country'],
                'faker_locale' => $val['faker_locale'],
                'time_zone' => $val['time_zone'],
                'country_code' => $val['country_code'],
                'status' => $val['status'],
            ]);
        }
    }
}
