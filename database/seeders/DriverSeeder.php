<?php

namespace Database\Seeders;

use App\Models\Driver;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Driver::create([
            'company_id' => 1,
            'full_name' => 'Aziz Azizov',
            'track_num' => 'A 077 ZZ',
            'eastern_time' => 'eastern_time one',
            'comment' => 'uyquchi driver',
            'tag' => 'NOT DOT'


        
        ]);

        Driver::create([
            'company_id' => 2,
            'full_name' => 'Kazim Kazimov',
            'track_num' => '033 ABA',
            'eastern_time' => 'eastern_time two',
            'comment' => 'DOT quvnoq driver',
            'tag' => 'NOT DOT'

        ]);

        

    }
}
