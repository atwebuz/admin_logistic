<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Product::create([
        //     'category_id' => 1,
        //     'company_id' => 1,
        //     'driver_id' => 1,
        //     'description_ru' => 'shunday task',
        //     'in_stock' => true,
        //     'level' => 'hard'

        // ]);
        // Product::create([
        //     'category_id' => 2,
        //     'company_id' => 2,
        //     'driver_id' => 2,
        //     'description_ru' => 'Help me pick a birthday gift for my mom who likes gardening Send a message',
        //     'in_stock' => true,
        //     'level' => 'easy'
        // ]);
        // Product::create([
        //     'category_id' => 2,
        //     'company_id' => 2,
        //     'driver_id' => 2,
        //     'description_ru' => 'Extra task',
        //     'in_stock' => true,
        //     'level' => 'easy',
        //     'is_extra' => 1,
        // ]);
 
        \Illuminate\Database\Eloquent\Factories\Factory::factoryForModel(Product::class)->times(20)->create();

  
    }
}
