<?php

namespace Core\Repository;


use Core\Models\Program;

class ProgramRepository
{
    /** @var Program $model */
    protected $model;

    public function __construct(Program $model)
    {
        $this->model = $model;
    }

    public function getPublishedByMeta($meta, $value)
    {
        return $this->getModel()->type('program')->published()->hasMeta($meta, $value)->first();
    }

    /**
     * @return Program
     */
    public function getModel()
    {
        return $this->model;
    }
}