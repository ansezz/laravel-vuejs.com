<?php

namespace Core\Controllers\Api;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Core\Services\CategoryService;

/**
 * Class PostController
 * @package Core\Controllers\Api
 */
class CategoryController extends ApiBaseController
{

    protected $categoryService;

    public function __construct(
        CategoryService $categoryService
    )
    {
        $this->categoryService = $categoryService;
    }

    public function index($locale = null)
    {
        try {
            $categories = $this->categoryService->categories($locale);

        } catch (ModelNotFoundException $e) {
            return $this->responseBuilder->withNotFound('not found');
        }

        return $categories;
    }
}