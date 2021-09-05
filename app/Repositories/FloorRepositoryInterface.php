<?php

namespace App\Repositories;

use App\Models\Floor;

interface FloorRepositoryInterface
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
     * @return Floor
     */
    public function getById($id);

    /**
     * Get data by number.
     *
     * @param $number
     * @return Floor
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
