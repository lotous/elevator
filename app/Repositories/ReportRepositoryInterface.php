<?php

namespace App\Repositories;

use App\Models\Elevator;
use App\Models\Report;
use Faker\Core\Number;
use Ramsey\Uuid\Type\Integer;

interface ReportRepositoryInterface
{
    /**
     * Get all data.
     *
     * @return array
     */
    public function getAll();

    /**
     * Get all data with paginate.
     *
     * @return array
     * @var $limit
     */
    public function getPaginate($limit);

    /**
     * Get data by id.
     *
     * @param $id
     * @return Report
     */
    public function getById($id);

    /**
     * Get data by sequence Id.
     *
     * @param $id
     * @return Report
     */
    public function getBySequenceId($id);

    /**
     * Get data by elevator Id.
     *
     * @param $id
     * @return Report
     */
    public function getByElevatorId($id);

    /**
     *
     *
     * @param $id
     * @param $time
     * @return Report
     */
    public function getByElevatorAtTime($id, $time);


    /**
     *
     *
     * @param $id
     * @param $time
     * @return Report
     */
    public function getByElevatorAtTimeLt($id, $time);

    /**
     * @param $id
     * @param $time
     * @return Number
     */
    public function getSumFloorTraveledByElevatorAtTime($id, $time);

    /**
     * Create new data.
     *
     * @param array $payload
     */
    public function create(array $payload);

    /**
     * Delete all data.
     *
     */
    public function deleteAll();
}
