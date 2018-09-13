<?php

namespace Core\Repository;

use Illuminate\Database\Eloquent\Model;
use Core\Models\Post;
use Core\Models\Taxonomy;

class TaxonomyRepository
{
    /** @var Taxonomy $model */
    protected $model;

    public function __construct(Taxonomy $model)
    {
        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }
}