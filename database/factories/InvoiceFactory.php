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
            'id_client' => Client::factory(),
            'id_item' => Item::factory(),
            'description' => $this->faker->text(),
        ];
    }
}
