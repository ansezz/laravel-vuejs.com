<?php

namespace Core\API\Controllers;

use Core\API\Services\PostService;
use Core\API\Transformers\PostTransformer;
use Core\API\Transformers\TermTransformer;
use Core\Exceptions\ModelNotFound;
use Themosis\Facades\Input;

class PostController extends BaseController
{

    /**
     * @param $arg
     * @param PostService $postService
     * @return array
     */
    public function show($arg, PostService $postService)
    {
        try {
            $item = $postService->findByIdOrSlug($arg, $this->locale);
        } catch (ModelNotFound $e) {
            return $this->response->withNotFound('Post ' . $e->getMessage());
        }

        return $this->response->withItem($item, new PostTransformer());
    }

    /**
     * @param PostService $postService
     * @return array
     */
    public function index(PostService $postService)
    {
        $limit = Input::get('limit');
        $page = Input::get('page');
        $items = $postService->paginate($page, $limit, $this->locale);

        return $this->response->withPaginate($items, new PostTransformer());
    }

    /**
     * @param $arg
     * @param PostService $postService
     * @return array
     */
    public function category($arg, PostService $postService)
    {
        $limit = Input::get('limit');
        $page = Input::get('page');

        try {
            $result = $postService->findByCategoryIdOrSlug($arg, $page, $limit, $this->locale);
        } catch (ModelNotFound $e) {
            return $this->response->withNotFound('Posts ' . $e->getMessage());
        }

        return $this->response->withPaginate($result, new PostTransformer());
    }
}