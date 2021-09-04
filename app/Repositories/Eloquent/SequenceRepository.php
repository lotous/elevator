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
    public function delete($id)
    {
        return $this->model->findOrFail($id)->delete();
    }

    /**
     * @inheritDoc
     */
    public function deleteAll()
    {
       return $this->model->truncate();
    }

}
