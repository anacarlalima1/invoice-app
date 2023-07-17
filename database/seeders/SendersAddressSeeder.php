<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SendersAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\SendersAddress::factory(10)->create();
    }
}
