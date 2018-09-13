<?php

namespace Core\Repository;


use Illuminate\Database\Eloquent\Model;
use Core\Models\Post;

class PostRepository
{
    /** @var Post $model */
    protected $model;

    public function __construct(Post $model)
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