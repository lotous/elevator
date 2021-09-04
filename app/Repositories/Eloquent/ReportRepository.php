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
    public function getAll(): array
    {
        return $this->model->all();
    }

    /**
     * @inheritDoc
     */
    public function getPaginate($limit): array
    {
        return $this->model->paginate($limit);
    }

    /**
     * @inheritDoc
     */
    public function getById($id): array
    {
        return $this->model->findOrFail($id);
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
    public function getBySequenceId($id): array
    {
        return  $this->model->where('sequence_id', $id)->firstOrFail();
    }

    /**
     * @inheritDoc
     */
    public function getByElevatorAtTime($id, $time)
    {
        return $this->model->where('elevator_id', $id)->where('time', '<=', date('H:i', $time))->orderBy('time', 'DESC')->first();
    }

    /**
     * @inheritDoc
     */
    public function getSumFloorTraveledByElevatorAtTime($id, $time)
    {
        return $this->model->where('elevator_id', $id)->where('time', '<=', date('H:i', $time))->get()->sum('floor_traveled');
    }

    /**
     * @inheritDoc
     */
    public function deleteAll()
    {
        return $this->model->truncate();
    }
}
