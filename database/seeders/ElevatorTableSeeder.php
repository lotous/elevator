<?php

namespace Database\Seeders;

use App\Models\Elevator;
use Illuminate\Database\Seeder;

class ElevatorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Elevator::factory()->count(3)->create();
    }
}
