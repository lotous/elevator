<?php

namespace Database\Factories;

use App\Models\Elevator;
use Illuminate\Database\Eloquent\Factories\Factory;

class ElevatorFactory extends Factory
{

    /**
     * Elevator number
     *
     * @var int
     */
    private static int $elevatorNumber = 1;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Elevator::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $number = self::$elevatorNumber++;
        return [
            'number' => $number,
            'name' => 'Elevator '.$number
        ];
    }
}
