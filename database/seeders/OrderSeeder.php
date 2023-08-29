<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders')->insert([
            'user_id' => 3,
            'product_id' => 1, // Provide a valid product_id here
            'status' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
