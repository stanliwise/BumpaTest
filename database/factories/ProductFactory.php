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
            'name' => $this->faker->words(3, true),
            'price' => $this->faker->randomFloat(2, 100, 1000.338),
            'sku' => $this->faker->bothify('??###??#??'),
            'quantity' => $this->faker->numberBetween(5, 20),
        ];
    }
}
