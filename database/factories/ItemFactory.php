<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'qty' => $this->faker->numberBetween(1, 800),
            'price' => $this->faker->randomFloat(2, 20, 30),
        ];
    }
}
