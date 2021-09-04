<?php

namespace App\Repositories;

interface ReportRepositoryInterface
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
     * @return array
     * @var $limit
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
     * Get data by sequence Id.
     *
     * @param $id
     * @return array
     */
    public function getBySequenceId($id): array;

    /**
     * @param $id
     * @param $time
     * @return mixed
     */
    public function getByElevatorAtTime($id, $time);

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
