<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createMultipleColor = [
            ['name'=>'Green','code'=>'#0e5737'],
            ['name'=>'Mustard','code'=>'#ffae23'],
            ['name'=>'Red','code'=>'#7a161c'],
            ['name'=>'Rock','code'=>'#c9bfb9'],
            ['name'=>'Orange','code'=>'#dd310f'],
            ['name'=>'Black','code'=>'#080105'],
            ['name'=>'Blue','code'=>'#0c3068'],
            ['name'=>'Pink','code'=>'#c41333'],
            ['name'=>'beige','code'=>'#b69578'],
        ];
        Color::insert($createMultipleColor);
    }
}
