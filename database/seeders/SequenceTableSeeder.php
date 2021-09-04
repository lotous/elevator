<?php

namespace Database\Seeders;

use App\Models\Sequence;
use Illuminate\Database\Seeder;

class SequenceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sequence::factory()->count(16)->create();
    }
}
