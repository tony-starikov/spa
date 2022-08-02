<?php

namespace Database\Seeders;

use App\Models\Apartment;
use Illuminate\Database\Seeder;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 11; $i++) {
            Apartment::create(
                [
                    'user_id' => 2,
                    'name' => 'Apartment ' . $i,
                    'image' => 'apartments_images/' . $i . '.jpg',
                ]
            );
        }
    }
}
