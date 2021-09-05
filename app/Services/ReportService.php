<?php

namespace App\Services;


use App\Models\Elevator;
use App\Models\Floor;
use App\Repositories\ElevatorRepositoryInterface;
use App\Repositories\FloorRepositoryInterface;
use App\Repositories\ReportRepositoryInterface;
use App\Repositories\SequenceRepositoryInterface;

class ReportService
{
    /**
     * @var ReportRepositoryInterface
     */
    private $reportRepository;

    /**
     * @var ElevatorRepositoryInterface
     */
    private $elevatorRepository;

    /**
     * @var FloorRepositoryInterface
     */
    private $floorRepository;

    /**
     * @var SequenceRepositoryInterface
     */
    private $sequenceRepository;

    /**
     *
     *
     * @param ReportRepositoryInterface $reportRepository
     * @param ElevatorRepositoryInterface $elevatorRepository
     * @param FloorRepositoryInterface $floorRepository
     * @param SequenceRepositoryInterface $sequenceRepository
     */
    public function __construct(ReportRepositoryInterface $reportRepository, ElevatorRepositoryInterface $elevatorRepository, FloorRepositoryInterface $floorRepository, SequenceRepositoryInterface $sequenceRepository)
    {
        $this->reportRepository = $reportRepository;
        $this->elevatorRepository = $elevatorRepository;
        $this->floorRepository = $floorRepository;
        $this->sequenceRepository = $sequenceRepository;
    }

    /**
     * get all data
     *
     * @return array
     */
    public function getAllData()
    {
        $this->executeSequence();
        return $this->reportData();
    }

    /**
     * get report data
     *
     * @return array
     */
    private function reportData(){
        $starTime = config('sequence.start_time');
        $endTime = config('sequence.end_time');
        $minutes = $this->getMinutes($starTime, $endTime);
        $elevators = $this->elevatorRepository->getAll();
        $data = [];
        for ($i = 0; $i <= $minutes; $i++) {
            foreach ($elevators as $elevator) {
                $currentTime = $i * 60 + strtotime($starTime);
                $floor = $this->getStartFloorLt($elevator->id, $currentTime);
                $floorTraveled = $this->reportRepository->getSumFloorTraveledByElevatorAtTime($elevator->id, $currentTime);
                $data[] = [
                    'time' => date('H:i', $currentTime),
                    'elevator' => $elevator->name,
                    'floor' => $floor->name,
                    'traveled' => $floorTraveled
                ];
            }
        }
        return $data;
    }

    /**
     * get minutes in hour range
     *
     * @param $startTime
     * @param $endTime
     * @return false|float
     */
    private function getMinutes($startTime, $endTime){
        return floor(abs(((strtotime($endTime)-strtotime($startTime))/60)));
    }


    /**
     * run the sequences
     *
     * @return void
     */
    private function executeSequence()
    {
        $sequences = $this->sequenceRepository->getAll();
        $this->reportRepository->deleteAll();
        foreach ($sequences as $sequence) {
            $minutes = $this->getMinutes($sequence->start_time, $sequence->end_time);
            $latency = ceil($minutes / $sequence->latency);
            for ($i = 0; $i <= $latency; $i++) {
                $currentTime = $i * $sequence->latency * 60 + strtotime($sequence->start_time);
                $elevator = $this->getAvailableElevator($currentTime);
                if ($elevator) {
                    $startFloor = $this->getStartFloor($elevator->id);
                    if($startFloor) {
                        $floorTraveled = ($sequence->end_floor->number + $sequence->start_floor->number) + abs($sequence->start_floor->number - $startFloor->number);
                        $this->reportRepository->create([
                            'current_time' => date('H:i', $currentTime),
                            'elevator_id' => $elevator->id,
                            'sequence_id' => $sequence->id,
                            'start_floor_id' => $startFloor->id,
                            'end_floor_id' => $sequence->end_floor_id,
                            'floor_traveled' => $floorTraveled,
                        ]);
                    }
               }
            }
        }
    }

    /**
     * get available elevator
     *
     * @param $time
     * @return Elevator|null
     */
    private function getAvailableElevator($time)
    {
           $elevators = $this->elevatorRepository->getAll();
           foreach ($elevators as $elevator) {
               $elevatorSearch = $this->reportRepository->getByElevatorAtTime($elevator->id, $time);
               if (is_null($elevatorSearch)) {
                   return $elevator;
               }
           }
          return null;
    }

    /**
     * get start floor for generate report
     *
     * @param $elevatorId
     * @param $time
     * @return Floor|mixed
     */
    private function getStartFloorLt($elevatorId, $time)
    {
        $elevator = $this->reportRepository->getByElevatorAtTimeLt($elevatorId, $time);
        return $elevator->end_floor ?? $this->floorRepository->getByNumber(config('sequence.start_floor_number'));
    }

    /**
     * get start floor for run sequences
     *
     * @param $elevatorId
     * @return Floor
     */
    private function getStartFloor($elevatorId)
    {
        $elevator = $this->reportRepository->getByElevatorId($elevatorId);
        return $elevator->end_floor ?? $this->floorRepository->getByNumber(config('sequence.start_floor_number'));
    }


}
