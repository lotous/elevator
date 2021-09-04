<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(ElevatorTableSeeder::class);
        $this->call(FloorTableSeeder::class);
        $this->call(SequenceTableSeeder::class);
        $this->call(ReportTableSeeder::class);

    }
}
