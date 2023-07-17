<?php

namespace Database\Factories;
use App\Models\Client;
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
            'street' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'country' => $this->faker->country(),
            'cep' => $this->faker->buildingNumber(),
        ];
    }
}
