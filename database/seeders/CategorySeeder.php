<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createMultipleCategories = [
            ['name'=>'shirts','slug'=>'shirts'],
            ['name'=>'abayas','slug'=>'abayas'],
            ['name'=>'Dresses','slug'=>'Dresses'],
            ['name'=>'evening-dresses','slug'=>'evening-dresses'],
            ['name'=>'jacket','slug'=>'jacket'],
            ['name'=>'jalabiyas','slug'=>'jalabiyas'],
            ['name'=>'jeans','slug'=>'jeans'],
            ['name'=>'sets','slug'=>'sets'],
            ['name'=>'Skirts','slug'=>'Skirts']
        ];
        Category::insert($createMultipleCategories);
        //User::create($arr);
    }
}
