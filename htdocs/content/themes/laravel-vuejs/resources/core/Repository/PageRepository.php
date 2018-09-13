<?php

namespace Core\Repository;


use Core\Models\Page;

use Core\Models\Post;

class PageRepository
{
    /** @var Page $model */
    protected $model;

    public function __construct(Page $model)
    {
        $this->model = $model;
    }

    /**
     * @return Post
     */
    public function getModel()
    {
        return $this->model;
    }
}