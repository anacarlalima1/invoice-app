<?php

namespace Database\Factories;
use App\Models\Invoice;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Item::class;

    public function definition()
    {
        $invoiceIds = Invoice::pluck('id')->all();

        return [
            'id_invoice' => $this->faker->randomElement($invoiceIds),
            'name' => $this->faker->word(),
            'qty' => $this->faker->numberBetween(1, 800),
            'price' => $this->faker->randomFloat(2, 20, 30),
        ];
    }
}
