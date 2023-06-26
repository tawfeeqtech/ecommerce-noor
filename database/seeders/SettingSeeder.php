<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [
            'website_name' => 'website_name',
            'website_url' => "website_url",
            'page_title' => "page_title",
            'meta_keywords' => "meta_keywords",
            'meta_description' => "meta_description",
            'address' => "address",
            'phone1' => "phone1",
            'phone2' => "phone2",
            'email1' => "email1",
            'email2' => "email2",
            'facebook' => "facebook",
            'twitter' => "twitter",
            'instagram' => "instagram",
            'youtube' => "youtube",
        ];

        Setting::create($arr);
    }
}
