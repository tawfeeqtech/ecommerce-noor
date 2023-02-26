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
            ['name'=>'38','code'=>'38'],
            ['name'=>'40','code'=>'40'],
            ['name'=>'42','code'=>'42'],
            ['name'=>'44','code'=>'44'],
            ['name'=>'46','code'=>'46'],
        ];
        Size::insert($createMultipleSize);
        //User::create($arr);
    }
}
