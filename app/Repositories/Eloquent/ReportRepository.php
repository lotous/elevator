<?php

namespace App\Repositories\Eloquent;

use App\Models\Report;
use App\Repositories\ReportRepositoryInterface;

class ReportRepository implements ReportRepositoryInterface
{

    /**
     * @var Report
     */
    protected $model;

    /**
     * @param Report $model
     */
    public function __construct(Report $model)
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
    public function create(array $payload)
    {
        return $this->model->create($payload);
    }

    /**
     * @inheritDoc
     */
    public function getBySequenceId($id)
    {
        return  $this->model->where('sequence_id', $id)->first();
    }

    /**
     * @inheritDoc
     */
    public function getByElevatorAtTime($id, $time)
    {
        return $this->model->where('elevator_id', $id)->where('current_time',date('H:i', $time))->first();
    }

    /**
     * @inheritDoc
     */
    public function getByElevatorAtTimeLt($id, $time)
    {
        return $this->model->where('elevator_id', $id)->where('current_time', '<=', date('H:i', $time))->orderBy('current_time', 'DESC')->first();
    }


    /**
     * @inheritDoc
     */
    public function getSumFloorTraveledByElevatorAtTime($id, $time)
    {
        return $this->model->where('elevator_id', $id)->where('current_time', '<=', date('H:i', $time))->sum('floor_traveled');
    }

    /**
     * @inheritDoc
     */
    public function deleteAll()
    {
        return $this->model->truncate();
    }

    /**
     * @inheritDoc
     */
    public function getByElevatorId($id)
    {
        return $this->model->where('elevator_id', $id)->orderBy('current_time', 'DESC')->first();
    }
}
