<?php

namespace Database\Seeders;

use App\Models\Deputi\StructureOrganization;
use App\Models\Inquiry\Inquiry;
use App\Models\Inquiry\InquiryField;
use Illuminate\Database\Seeder;

class ContentDefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //-- structure --//
        $structures = [
            0 => [
                'unit_code' => '4000000',
                'name' => [
                    'id' => 'Kepala BPPT',
                    'en' => 'Kepala BPPT',
                ],
                'slug' => 'kepalabppt',
                'description' => [
                    'id' => null,
                    'en' => null,
                ],
                'position' => 1,
            ],
            1 => [
                'unit_code' => '4100000',
                'name' => [
                    'id' => 'Sekretariat Utama',
                    'en' => 'Sekretariat Utama',
                ],
                'slug' => 'sekretariat-utama',
                'description' => [
                    'id' => null,
                    'en' => null,
                ],
                'position' => 2,
            ],
            2 => [
                'unit_code' => '4200000',
                'name' => [
                    'id' => 'Bidang Pengkajian Kebijakan Teknologi',
                    'en' => 'Bidang Pengkajian Kebijakan Teknologi',
                ],
                'slug' => 'deputi-pkt',
                'description' => [
                    'id' => null,
                    'en' => null,
                ],
                'position' => 3,
            ],
            3 => [
                'unit_code' => '4300000',
                'name' => [
                    'id' => 'Bidang Teknologi Pengembangan Sumber Daya Alam',
                    'en' => 'Bidang Teknologi Pengembangan Sumber Daya Alam',
                ],
                'slug' => 'deputi-tpsa',
                'description' => [
                    'id' => null,
                    'en' => null,
                ],
                'position' => 4,
            ],
            4 => [
                'unit_code' => '4400000',
                'name' => [
                    'id' => 'Bidang Teknologi Agroindustri dan Bioteknologi',
                    'en' => 'Bidang Teknologi Agroindustri dan Bioteknologi',
                ],
                'slug' => 'deputi-tab',
                'description' => [
                    'id' => null,
                    'en' => null,
                ],
                'position' => 5,
            ],
            5 => [
                'unit_code' => '4500000',
                'name' => [
                    'id' => 'Bidang Teknologi Informasi, Energi, dan Material',
                    'en' => 'Bidang Teknologi Informasi, Energi, dan Material',
                ],
                'slug' => 'deputi-tiem',
                'description' => [
                    'id' => null,
                    'en' => null,
                ],
                'position' => 6,
            ],
            6 => [
                'unit_code' => '4600000',
                'name' => [
                    'id' => 'Bidang Teknologi Industri Rancang Bangun dan Rekayasa',
                    'en' => 'Bidang Teknologi Industri Rancang Bangun dan Rekayasa',
                ],
                'slug' => 'deputi-tirbr',
                'description' => [
                    'id' => null,
                    'en' => null,
                ],
                'position' => 7,
            ],
        ];

        foreach ($structures as $val) {

            StructureOrganization::create([
                'unit_code' => $val['unit_code'],
                'name' => $val['name'],
                'slug' => $val['slug'],
                'description' => $val['description'],
                'position' => $val['position'],
                'created_by' => 1,
                'updated_by' => 1,
            ]);

        }

        //-- inquiry --//
        $inquiries = [
            0 => [
                'name' => [
                    'id' => 'Kontak Kami',
                    'en' => 'Contact Us'
                ],
                'slug' => 'kontak',
                'body' => [
                    'id' => '<h5 class="my-3">Kantor BPPT</h5>',
                    'en' => '<h5 class="my-3">BPPT Office</h5>',
                ],
                'after_body' => [
                    'id' => 'Terima kasih atas timbal balik anda!',
                    'en' => 'Thanks For Your Feedback!',
                ],
                'banner' => [
                    'file_path' => null,
                    'title' => null,
                    'alt' => null,
                ],
                'email' => null,
                'show_form' => 1,
                'show_map' => 1,
                'is_detail' => 1,
                'longitude' => '106.8205553',
                'latitude' => '-6.1848914',
                'meta_data' => [
                    'title' => null,
                    'description' => null,
                    'keywords' => null,
                ],
                'position' => 1,
            ],
        ];

        foreach ($inquiries as $val) {
            
            Inquiry::create([
                'name' => $val['name'],
                'slug' => $val['slug'],
                'body' => $val['body'],
                'after_body' => $val['after_body'],
                'banner' => $val['banner'],
                'publish' => 1,
                'is_detail' => $val['is_detail'],
                'show_form' => $val['show_form'],
                'email' => $val['email'],
                'show_map' => $val['show_map'],
                'longitude' => $val['longitude'],
                'latitude' => $val['latitude'],
                'meta_data' => $val['meta_data'],
                'position' => $val['position'],
                'created_by' => 1,
                'updated_by' => 1,
            ]);

        }

        $inquiryFields = [
            0 => [
                'inquiry_id' => 1,
                'label' => [
                    'id' => 'Nama Lengkap',
                    'en' => 'Full Name',
                ],
                'name' => 'name',
                'type' => 0,
                'properties' => [
                    'id' => null,
                    'attr' => null,
                    'type' => 'text',
                    'class' => 'col-xl-6',
                ],
                'position' => 1,
                'validation' => 'required'
            ],
            1 => [
                'inquiry_id' => 1,
                'label' => [
                    'id' => 'Email',
                    'en' => 'Email',
                ],
                'name' => 'email',
                'type' => 0,
                'properties' => [
                    'id' => null,
                    'attr' => null,
                    'type' => 'email',
                    'class' => 'col-xl-6',
                ],
                'position' => 2,
                'validation' => 'required|email'
            ],
            2 => [
                'inquiry_id' => 1,
                'label' => [
                    'id' => 'Subyek',
                    'en' => 'Subject',
                ],
                'name' => 'subject',
                'type' => 1,
                'properties' => [
                    'id' => null,
                    'attr' => null,
                    'type' => 'text',
                    'class' => 'col-xl-12',
                ],
                'position' => 3,
                'validation' => 'required'
            ],
            3 => [
                'inquiry_id' => 1,
                'label' => [
                    'id' => 'Pesan',
                    'en' => 'Message',
                ],
                'name' => 'message',
                'type' => 1,
                'properties' => [
                    'id' => null,
                    'attr' => null,
                    'type' => 'text',
                    'class' => 'col-xl-12',
                ],
                'position' => 4,
                'validation' => 'required'
            ],
        ];

        foreach ($inquiryFields as $val) {
            
            InquiryField::create([
                'inquiry_id' => $val['inquiry_id'],
                'label' => $val['label'],
                'name' => $val['name'],
                'type' => $val['type'],
                'properties' => $val['properties'],
                'position' => $val['position'],
                'validation' => $val['validation'],
                'created_by' => 1,
                'updated_by' => 1,
            ]);

        }
    }
}
