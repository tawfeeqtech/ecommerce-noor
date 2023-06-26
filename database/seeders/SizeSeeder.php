<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createMultipleSize = [
            ['name'=>'xs','code'=>'xs'],
            ['name'=>'s','code'=>'s'],
            ['name'=>'m','code'=>'m'],
            ['name'=>'l','code'=>'l'],
            ['name'=>'xl','code'=>'xl'],
        ];
        Size::insert($createMultipleSize);
    }
}
