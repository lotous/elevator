<?php

namespace App\Repositories\Eloquent;

use App\Models\Elevator;
use App\Repositories\ElevatorRepositoryInterface;

class ElevatorRepository implements ElevatorRepositoryInterface
{

    /**
     * @var Elevator
     */
    protected $model;

    /**
     * @param Elevator $model
     */
    public function __construct(Elevator $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritDoc
     */
    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * @inheritDoc
     */
    public function getPaginate($limit)
    {
        return $this->model->paginate($limit);
    }

    /**
     * @inheritDoc
     */
    public function getById($id)
    {
        return $this->model->find($id);
    }

    /**
     * @inheritDoc
     */
    public function getByNumber($number)
    {
        return  $this->model->where('number', $number)->first();
    }

    /**
     * @inheritDoc
     */
    public function create(array $payload)
    {
        return $this->model->create($payload);
    }

    /**
     * @inheritDoc
     */
    public function update($id, array $payload)
    {
        return $this->model->find($id)->update($payload);
    }

    /**
     * @inheritDoc
     */
    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }
}
