<?php

namespace App\Repositories\Eloquent;

use App\Models\Sequence;
use App\Repositories\SequenceRepositoryInterface;

class SequenceRepository implements SequenceRepositoryInterface
{

    /**
     * @var Sequence
     */
    protected $model;

    /**
     * @param Sequence $model
     */
    public function __construct(Sequence $model)
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
    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }

    /**
     * @inheritDoc
     */
    public function deleteAll()
    {
       return $this->model->truncate();
    }

}
