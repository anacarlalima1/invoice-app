<?php

namespace Database\Factories;
use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class SendersAddressFactory extends Factory
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
            'street' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'country' => $this->faker->country(),
            'cep' => $this->faker->buildingNumber(),
        ];
    }
}
