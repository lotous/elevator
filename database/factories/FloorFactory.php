<?php

namespace Database\Factories;

use App\Models\Floor;
use Illuminate\Database\Eloquent\Factories\Factory;

class FloorFactory extends Factory
{

    /**
     * Floor number
     *
     * @var int
     */
    private static int $floorNumber = 0;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Floor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $number = self::$floorNumber++;
        return [
           'number' => $number,
           'name' => 'Floor '.$number
        ];
    }
}
