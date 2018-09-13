<?php

namespace Core\Repository;

use Core\Models\Menu;

class MenuRepository
{
    /** @var Menu $model */
    protected $model;

    public function __construct(Menu $model)
    {
        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }
}