<?php

namespace App\Repositories;

interface ElevatorRepositoryInterface
{
    /**
     * Get all data.
     *
     * @return array
     */
    public function getAll(): array;

    /**
     * Get all data with paginate.
     *
     * @var $limit
     * @return array
     */
    public function getPaginate($limit): array;

    /**
     * Get data by id.
     *
     * @param $id
     * @return array
     */
    public function getById($id): array;

    /**
     * Get data by number.
     *
     * @param $number
     * @return array
     */
    public function getByNumber($number): array;

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
