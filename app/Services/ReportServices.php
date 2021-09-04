<?php

namespace App\Services;


use App\Repositories\ElevatorRepositoryInterface;
use App\Repositories\Eloquent\ElevatorRepository;
use App\Repositories\FloorRepositoryInterface;
use App\Repositories\ReportRepositoryInterface;
use App\Repositories\SequenceRepositoryInterface;

class ReportServices
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
        return $this->repository->getAll();
    }



    public function generateData()
    {
        $starTime = strtotime(config('sequence.start_time'));
        $endTime = strtotime(config('sequence.end_time'));

        $diffTime = floor(($endTime - $starTime) / 60);


        $sequences = $this->sequenceRepository->getAll();
        $this->reportRepository->deleteAll();
        $this->runSequences($sequences);




        echo config('building.report_header');
        for ($i = 0; $i <= $diffTimeMinutes; $i++) {
            for ($elevatorNumber = 1; $elevatorNumber <= config('building.number_of_elevators'); $elevatorNumber++) {
                $this->generateSingleElementReport($i, $starTime, $elevatorNumber);
            }
        }
    }

    /**
     * @param $time
     * @return int|null
     */
    private function checkAvailableElevator($time)
    {
        for ($i = 1; $i <= config('building.number_of_elevators'); $i++) {
            $elevatorBusy = ElevatorReport::where('elevator_number', $i)->where('time', date('H:i', $time))->first();
            if (is_null($elevatorBusy)) {
                return $i;
            }
        }

        return null;
    }

    /**
     * @param $elevatorNumber
     * @return mixed
     */
    private function checkElevatorCurrentFloor($elevatorNumber)
    {
        $lastElevator = ElevatorReport::where('elevator_number', $elevatorNumber)->orderBy('time', 'DESC')->first();
        if (is_null($lastElevator)) {
            return config('building.start_floor');
        } else {
            return $lastElevator->end_floor;
        }
    }

    /**
     * @param $currentTime
     * @param $sequenceId
     * @param $elevatorId
     * @param $startFloorId
     * @param $endFloorId
     * @param $floorTraveled
     */
    private function saveStep($currentTime, $sequenceId, $elevatorId, $startFloorId, $endFloorId, $floorTraveled)
    {
        $this->reportRepository->create([
            'current_time' => date('H:i', $currentTime),
            'elevator_id' => $elevatorId,
            'sequence_id' => $sequenceId,
            'start_floor_id' => $startFloorId,
            'end_floor_id' => $endFloorId,
            'floor_traveled' => $floorTraveled,
        ]);
    }

    /**
     * @param $endFloorNumber
     * @param $startFloorNumber
     * @param $elevatorFloor
     * @return float|int
     */
    private function floorTraveled($endFloorNumber, $startFloorNumber, $elevatorFloor)
    {
        return $endFloorNumber + $startFloorNumber + abs( $startFloorNumber - $elevatorFloor);
    }

    /**
     * @param $elevatorSequences
     */
    private function runSequence($elevatorSequences)
    {

        foreach ($elevatorSequences as $elevatorSequence) {
            $starTime = strtotime($elevatorSequence->start_time);
            $endTime = strtotime($elevatorSequence->end_time);

            $diffTimeMinutes = floor(($endTime - $starTime) / 60);
            $elevatorRepetitions = ceil($diffTimeMinutes / $elevatorSequence->interval);

            for ($i = 0; $i <= $elevatorRepetitions; $i++) {
                $this->executeSingleElevatorRepetition($i, $elevatorSequence, $starTime);
            }
        }
    }

    /**
     * @param $elevatorId
     * @param $time
     * @return array
     */
    private function startFloorNumber($elevatorId, $time)
    {
        $report = $this->reportRepository->getByElevatorAtTime($elevatorId,$time);
        return $report ? $report->end_floor : $this->floorRepository->getByNumber(config('building.start_floor'));
    }

    /**
     * @param $elevatorNumber
     * @param $currentTime
     * @return mixed
     */
    private function getElevatorSumOfFloorsAtTime($elevatorNumber, $currentTime)
    {
        return ElevatorReport::where('elevator_number', $elevatorNumber)->where('time', '<=', date('H:i', $currentTime))->get()->sum('floor_moves');
    }

    /**
     * @param $i
     * @param $starTime
     * @param $elevatorNumber
     */
    private function generateSingleElementReport($i, $starTime, $elevatorNumber)
    {
        $currentTime = $i * config('building.minutes_in_one_hour') + $starTime;
        $floorAtTime = $this->getElevatorFloorsAtTime($elevatorNumber, $currentTime);
        $sumOfFloorsAtTime = $this->getElevatorSumOfFloorsAtTime($elevatorNumber, $currentTime);
        echo date('H:i', $currentTime) . str_repeat('_', 7) .
            $elevatorNumber . str_repeat('_', 6) .
            $floorAtTime . str_repeat('_', 11) .
            $sumOfFloorsAtTime . '<br />';
    }

    /**
     * @param $availableElevatorNumber
     * @param $elevatorSequence
     * @param $currentTime
     */
    private function moveElevator($availableElevatorNumber, $elevatorSequence, $currentTime)
    {
        $elevatorFloor = $this->checkElevatorCurrentFloor($availableElevatorNumber);
        $elevatorFloorMoves = $this->getElevatorFloorMoves($elevatorSequence, $elevatorFloor);
        $this->saveElevatorMoveInReport(
            $availableElevatorNumber,
            $currentTime,
            $elevatorFloor,
            $elevatorSequence,
            $elevatorFloorMoves
        );
    }

    /**
     * @param $i
     * @param $elevatorSequence
     * @param $starTime
     */
    private function executeSingleElevatorRepetition($i, $elevatorSequence, $starTime)
    {
        $currentTime = $i * $elevatorSequence->interval * 60 + $starTime;
        $availableElevatorNumber = $this->checkAvailableElevator($currentTime);
        if (is_null($availableElevatorNumber)) {
            echo config('building.no_elevator_available_text') . date('H:i', $currentTime) . '<br />';
        } else {
            $this->moveElevator($availableElevatorNumber, $elevatorSequence, $currentTime);
        }
    }


}
