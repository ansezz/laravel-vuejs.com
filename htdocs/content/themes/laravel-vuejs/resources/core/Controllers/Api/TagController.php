<?php

namespace Core\Controllers\Api;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Core\Services\TagService;

/**
 * Class PostController
 * @package Core\Controllers\Api
 */
class TagController extends ApiBaseController
{

    protected $tagService;

    public function __construct(
        TagService $tagService
    )
    {
        $this->tagService = $tagService;
    }

    public function index($locale = null)
    {
        try {
            $tags = $this->tagService->tags($locale);

        } catch (ModelNotFoundException $e) {
            return $this->responseBuilder->withNotFound('not found');
        }

        return $tags;
    }
}