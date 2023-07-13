<?php

namespace Database\Factories;
use App\Models\Invoice;
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
            'id_invoice' =>  Invoice::inRandomOrder()->first()->id,
            'name' => $this->faker->word(),
            'qty' => $this->faker->numberBetween(1, 800),
            'price' => $this->faker->randomFloat(2, 20, 30),
        ];
    }
}
