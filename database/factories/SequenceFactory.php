<?php

namespace Database\Factories;

use App\Models\Floor;
use App\Models\Sequence;
use Illuminate\Database\Eloquent\Factories\Factory;

class SequenceFactory extends Factory
{


    /**
     * Sequence number
     *
     * @var int
     */
    private static int $sequenceNumber = 0;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sequence::class;

    /**
     * array of custom sequences
     *
     * @var array
     */
    private static $customSequence = [];

    /**
     * get array of sequences
     *
     * @return array
     */
    private static function customSequence()
    {

        if (empty(self::$customSequence)) {
            $floors = Floor::all();
            foreach ($floors as $floor) {
                if ($floor->number == 2) {
                    // Cada 5 minutos de 09:00h a 11:00h llaman al ascensor desde la planta baja para ir a las planta 2
                    self::$customSequence[] = [
                        "start_time" => '09:00',
                        "end_time" => '11:00',
                        "start_floor_id" => Floor::where('number', '0')->first()->id,
                        "end_floor_id" => $floor->id,
                        "latency" => 5
                    ];
                }
                if ($floor->number == 3) {
                    // Cada 5 minutos de 09:00h a 11:00h llaman al ascensor desde la planta baja para ir a la planta 3
                    self::$customSequence[] = [
                        "start_time" => '09:00',
                        "end_time" => '11:00',
                        "start_floor_id" => Floor::where('number', '0')->first()->id,
                        "end_floor_id" => $floor->id,
                        "latency" => 5
                    ];
                }
                if ($floor->number == 1) {
                    //Cada 10 minutos de 09:00h a 10:00h llaman al ascensor desde la planta baja para a las planta 1
                    self::$customSequence[] = [
                        "start_time" => '09:00',
                        "end_time" => '10:00',
                        "start_floor_id" => Floor::where('number', '0')->first()->id,
                        "end_floor_id" => $floor->id,
                        "latency" => 10
                    ];
                }
                if ($floor->number != 0) {
                    // Cada 20 minutos de 11:00h a 18:20h llaman al ascensor desde la planta baja para ir a todas las plantas
                    self::$customSequence[] = [
                        "start_time" => '11:00',
                        "end_time" => '18:20',
                        "start_floor_id" => Floor::where('number', '0')->first()->id,
                        "end_floor_id" => $floor->id,
                        "latency" => 20
                    ];
                }
                if ($floor->number == 1 or $floor->number == 2 or $floor->number == 3) {
                    // Cada 4 minutos de 14:00h a 15:00h llaman al ascensor desde las plantas 1, 2 y 3 para ir a la planta baja
                    self::$customSequence[] = [
                        "start_time" => '14:00',
                        "end_time" => '15:00',
                        "start_floor_id" => $floor->id,
                        "end_floor_id" => Floor::where('number', '0')->first()->id,
                        "latency" => 4
                    ];
                }
                if ($floor->number == 2 or $floor->number == 3) {
                    // Cada 7 minutos de 15:00h a 16:00h llaman al ascensor desde las plantas 2 y 3 para ir a la planta baja
                    self::$customSequence[] = [
                        "start_time" => '15:00',
                        "end_time" => '16:00',
                        "start_floor_id" => $floor->id,
                        "end_floor_id" => Floor::where('number', '0')->first()->id,
                        "latency" => 7
                    ];
                }

                if ($floor->number == 1 or $floor->number == 3) {
                    // Cada 7 minutos de 15:00h a 16:00h llaman al ascensor desde la planta baja para ir a las plantas 1 y 3
                    self::$customSequence[] = [
                        "start_time" => '15:00',
                        "end_time" => '16:00',
                        "start_floor_id" => Floor::where('number', '0')->first()->id,
                        "end_floor_id" => $floor->id,
                        "latency" => 7
                    ];
                }

                if ($floor->number == 1 or $floor->number == 2 or $floor->number == 3) {
                    // Cada 3 minutos de 18:00h a 20:00h llaman al ascensor desde las plantas 1, 2 y 3 para ir a la planta baja
                    self::$customSequence[] = [
                        "start_time" => '18:00',
                        "end_time" => '20:00',
                        "start_floor_id" => $floor->id,
                        "end_floor_id" => Floor::where('number', '0')->first()->id,
                        "latency" => 3
                    ];
                }
            }
        }
        return self::$customSequence;
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $customSequence = self::customSequence();
        if (isset($customSequence[self::$sequenceNumber])) {
            $newSequence = $customSequence[self::$sequenceNumber];
        } else {
            $newSequence = [
                "start_time" => $this->faker->time('H:i'),
                "end_time" => $this->faker->time('H:i'),
                "start_floor_id" => Floor::all()->random()->id,
                "end_floor_id" => Floor::all()->random()->id,
                "latency" => $this->faker->numberBetween(1, 60)
            ];
        }
        self::$sequenceNumber++;
        return $newSequence;
    }
}
