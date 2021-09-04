<?php

namespace App\Repositories;

interface SequenceRepositoryInterface
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
     * Create new data.
     *
     * @param array $payload
     */
    public function create(array $payload);

    /**
     * Delete data.
     *
     * @param $id
     */
    public function delete($id);

    /**
     * Delete all data.
     *
     */
    public function deleteAll();
}
