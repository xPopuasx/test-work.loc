<?php

namespace Database\Seeders;

use App\Models\Car\Car;
use Illuminate\Database\Seeder;

class CarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Car::factory()->count(10)->create();
    }
}
