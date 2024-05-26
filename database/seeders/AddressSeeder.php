<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 0; $i < 10; $i++) {
            Address::create([
                'line_1' => fake()->buildingNumber,
                'line_2' => fake()->streetName,
                'city' => fake()->city,
                'zip_code' => fake()->postcode,
            ]);
        }
    }
}
