<?php

namespace Database\Seeders;

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
        //-- inquiry --//
        $inquiries = [
            0 => [
                'name' => [
                    'id' => 'Kontak Kami',
                    'en' => 'Contant Us'
                ],
                'slug' => 'contact-us',
                'body' => [
                    'id' => '<h2 class="title">Content here</h2>',
                    'en' => '<h2 class="title">Content here</h2>',
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
                'show_form' => 0,
                'show_map' => 1,
                'is_detail' => 1,
                'longitude' => '',
                'latitude' => '',
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
                    'id' => 'Nama',
                    'en' => 'Name',
                ],
                'name' => 'name',
                'type' => 0,
                'properties' => [
                    'id' => null,
                    'attr' => null,
                    'type' => 'text',
                    'class' => 'col-lg-6',
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
                    'class' => 'col-lg-6',
                ],
                'position' => 2,
                'validation' => 'required|email'
            ],
            2 => [
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
                    'class' => 'col-lg-12',
                ],
                'position' => 3,
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
