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
        Category::create([
            'name_ru' => 'Test_ru',
            'default_quantity' => 2,
            'deadline' => 20,

        ]);

        Category::create([
            'name_ru' => 'second',
            'default_quantity' =>7,
            'deadline' => 24,
        ]);
    }
}
