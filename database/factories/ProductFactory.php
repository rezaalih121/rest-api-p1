<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     * created using : php artisan make:factory ProductFactory
     * To use it and insert random data to this table use following command : 
     * php artisan tinker
     * User::factory()->times(25)->create();
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::all()->random()->id,
            'name' => $this->faker->unique()->company(),
            'slug' => $this->faker->unique()->sentence(),
            'description' => $this->faker->text(),
            'price' => $this->faker->randomFloat()
        ];
    }
}
