<?php

namespace Core\API\Services;

use Core\Models\BaseModel;

class Service implements ServiceInterface
{
    protected $model;

    /**
     * BaseService constructor.
     * @param BaseModel $model
     */
    public function __construct(BaseModel $model)
    {
        $this->model = $model;
    }
}