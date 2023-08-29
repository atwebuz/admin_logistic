<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => $this->faker->numberBetween(1, 2), // Assuming you have 10 categories
            'company_id' => $this->faker->numberBetween(1, 2), // Assuming you have 20 companies
            'driver_id' => $this->faker->numberBetween(1, 2),   // Assuming you have 5 drivers
            'description_ru' => $this->faker->paragraph,
            'in_stock' => 1,
            'is_extra' => $this->faker->boolean,
            'level' => $this->faker->randomElement(['hard', 'middle','easy']),
            'created_at' => $this->faker->dateTimeBetween('-1 year'), // Example: within the past year
        ];
    }
}
