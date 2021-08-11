<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $configuration = [
            0 => [
                'group' => 1,
                'name' => 'logo',
                'label' => 'Logo',
                'value' => null,
                'is_upload' => true,
            ],
            1 => [
                'group' => 1,
                'name' => 'logo_2',
                'label' => 'Logo 2',
                'value' => null,
                'is_upload' => true,
            ],
            2 => [
                'group' => 1,
                'name' => 'logo_small',
                'label' => 'Logo Small',
                'value' => null,
                'is_upload' => true,
            ],
            3 => [
                'group' => 1,
                'name' => 'logo_small_2',
                'label' => 'Logo Small 2',
                'value' => null,
                'is_upload' => true,
            ],
            4 => [
                'group' => 1,
                'name' => 'logo_mail',
                'label' => 'Logo Mail',
                'value' => null,
                'is_upload' => true,
            ],
            5 => [
                'group' => 1,
                'name' => 'open_graph',
                'label' => 'Open Graph',
                'value' => null,
                'is_upload' => true,
            ],
            6 => [
                'group' => 1,
                'name' => 'banner_default',
                'label' => 'Banner',
                'value' => null,
                'is_upload' => true,
            ],
            7 => [
                'group' => 2,
                'name' => 'website_name',
                'label' => 'Website Name',
                'value' => 'BADAN PENGKAJIAN DAN PENERAPAN TEKNOLOGI',
                'is_upload' => false,
            ],
            8 => [
                'group' => 2,
                'name' => 'website_description',
                'label' => 'Website Description',
                'value' => 'Solid Smart Speed',
                'is_upload' => false,
            ],
            9 => [
                'group' => 2,
                'name' => 'banner_limit',
                'label' => 'Banner Limit',
                'value' => 4,
                'is_upload' => false,
            ],
            10 => [
                'group' => 2,
                'name' => 'content_limit',
                'label' => 'Content Limit',
                'value' => 12,
                'is_upload' => false,
            ],
            11 => [
                'group' => 2,
                'name' => 'address',
                'label' => 'Address',
                'value' => 'Bagian Humas Gedung B.J. Habibie Lantai 14 Jl. M.H Thamrin No. 8 Jakarta Pusat DKI Jakarta 10340',
                'is_upload' => false,
            ],
            12 => [
                'group' => 2,
                'name' => 'email',
                'label' => 'Email',
                'value' => 'humas@bppt.go.id',
                'is_upload' => false,
            ],
            13 => [
                'group' => 2,
                'name' => 'email_2',
                'label' => 'Email 2',
                'value' => null,
                'is_upload' => false,
            ],
            14 => [
                'group' => 2,
                'name' => 'fax',
                'label' => 'FAX',
                'value' => '(021) 398 38729',
                'is_upload' => false,
            ],
            15 => [
                'group' => 2,
                'name' => 'phone',
                'label' => 'Phone',
                'value' => '(021) 316 9457',
                'is_upload' => false,
            ],
            16 => [
                'group' => 2,
                'name' => 'phone_2',
                'label' => 'Phone 2',
                'value' => null,
                'is_upload' => false,
            ],
            17 => [
                'group' => 2,
                'name' => 'phone_whatsapp',
                'label' => 'Phone Whatsapp',
                'value' => null,
                'is_upload' => false,
            ],
            18 => [
                'group' => 3,
                'name' => 'meta_title',
                'label' => 'Meta Title',
                'value' => 'BADAN PENGKAJIAN DAN PENERAPAN TEKNOLOGI',
                'is_upload' => false,
            ],
            19 => [
                'group' => 3,
                'name' => 'meta_description',
                'label' => 'Meta Description',
                'value' => 'Solid Smart Speed',
                'is_upload' => false,
            ],
            20 => [
                'group' => 3,
                'name' => 'meta_keywords',
                'label' => 'Meta Keywords',
                'value' => null,
                'is_upload' => false,
            ],
            21 => [
                'group' => 3,
                'name' => 'google_analytics',
                'label' => 'Google Analytics (script)',
                'value' => null,
                'is_upload' => false,
            ],
            // 22 => [
            //     'group' => 1,
            //     'name' => 'google_analytics_api',
            //     'label' => 'Service Account Credentials',
            //     'value' => null,
            //     'is_upload' => true,
            // ],
            // 23 => [
            //     'group' => 3,
            //     'name' => 'google_analytics_view_id',
            //     'label' => 'Google Analytics View ID',
            //     'value' => null,
            //     'is_upload' => false,
            // ],
            24 => [
                'group' => 3,
                'name' => 'google_verification',
                'label' => 'Google Verification',
                'value' => null,
                'is_upload' => false,
            ],
            25 => [
                'group' => 3,
                'name' => 'domain_verification',
                'label' => 'Domain Verification',
                'value' => null,
                'is_upload' => false,
            ],
            26 => [
                'group' => 4,
                'name' => 'app_store',
                'label' => 'App Store',
                'value' => null,
                'is_upload' => false,
            ],
            27 => [
                'group' => 4,
                'name' => 'google_play_store',
                'label' => 'Google Play Store',
                'value' => null,
                'is_upload' => false,
            ],
            // 28 => [
            //     'group' => 4,
            //     'name' => 'google_plus',
            //     'label' => 'Google Plus URL',
            //     'value' => null,
            //     'is_upload' => false,
            // ],
            29 => [
                'group' => 4,
                'name' => 'facebook',
                'label' => 'Facebook URL',
                'value' => 'https://www.facebook.com/BPPTRI',
                'is_upload' => false,
            ],
            30 => [
                'group' => 4,
                'name' => 'instagram',
                'label' => 'Instagram URL',
                'value' => 'https://www.instagram.com/bppt_ri/',
                'is_upload' => false,
            ],
            31 => [
                'group' => 4,
                'name' => 'linkedin',
                'label' => 'LinkedIn URL',
                'value' => null,
                'is_upload' => false,
            ],
            32 => [
                'group' => 4,
                'name' => 'pinterest',
                'label' => 'Pinterest URL',
                'value' => null,
                'is_upload' => false,
            ],
            33 => [
                'group' => 4,
                'name' => 'twitter',
                'label' => 'Twitter URL',
                'value' => 'https://twitter.com/bppt_ri',
                'is_upload' => false,
            ],
            34 => [
                'group' => 4,
                'name' => 'whatsapp',
                'label' => 'WhatsApp URL',
                'value' => null,
                'is_upload' => false,
            ],
            35 => [
                'group' => 4,
                'name' => 'youtube',
                'label' => 'Youtube URL',
                'value' => 'https://www.youtube.com/channel/UCTqpJRtdswcFupxEZIjvr9w',
                'is_upload' => false,
            ],
            36 => [
                'group' => 4,
                'name' => 'youtube_id',
                'label' => 'Youtube ID',
                'value' => null,
                'is_upload' => false,
            ],
            37 => [
                'group' => 4,
                'name' => 'website',
                'label' => 'Website URL',
                'value' => 'https://www.bppt.go.id/',
                'is_upload' => false,
            ],
            38 => [
                'group' => 5,
                'name' => 'kepala_bppt',
                'label' => 'Kepala BPPT',
                'value' => 'Dr. Ir. Hammam Riza, M.sc.',
                'is_upload' => false,
            ],
            39 => [
                'group' => 5,
                'name' => 'layanan_bppt',
                'label' => 'Layanan BPPT',
                'value' => 'https://layanan.bppt.go.id/',
                'is_upload' => false,
            ],
            40 => [
                'group' => 1,
                'name' => 'panduan_identitas',
                'label' => 'Panduan Identitas',
                'value' => 'Panduan-Identitas-BPPT.pdf',
                'is_upload' => true,
            ],
        ];

        foreach ($configuration as $val) {
            
            Configuration::create([
                'group' => $val['group'],
                'name' => $val['name'],
                'label' => $val['label'],
                'value' => $val['value'],
                'is_upload' => $val['is_upload'],
            ]);
        }
    }
}
