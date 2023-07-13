<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_client' =>  Client::inRandomOrder()->first()->id,
            'description' => $this->faker->text(),
            'data_payment' => $this->faker->date(),
        ];
    }
}
