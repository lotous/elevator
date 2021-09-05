<?php

namespace App\Repositories;

use App\Models\Sequence;

interface SequenceRepositoryInterface
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
     * @return Sequence
     */
    public function getById($id);

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
