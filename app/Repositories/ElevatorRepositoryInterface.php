<?php

namespace App\Repositories;

use App\Models\Elevator;

interface ElevatorRepositoryInterface
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
     * @var $limit
     * @return array
     */
    public function getPaginate($limit);

    /**
     * Get data by id.
     *
     * @param $id
     * @return Elevator
     */
    public function getById($id);

    /**
     * Get data by number.
     *
     * @param $number
     * @return Elevator
     */
    public function getByNumber($number);

    /**
     * Create new data.
     *
     * @param array $payload
     */
    public function create(array $payload);

    /**
     * Update data.
     *
     * @param $id
     * @param array $payload
     */
    public function update($id, array $payload);

    /**
     * Delete data.
     *
     * @param $id
     */
    public function delete($id);
}
