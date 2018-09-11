<?php

namespace Core\API\Controllers;

use Core\API\Services\PostService;
use Core\API\Transformers\PostTransformer;
use Themosis\Facades\Input;

class FeaturedController extends BaseController
{

    /**
     * @param PostService $postService
     * @return array
     */
    public function index(PostService $postService)
    {
        $limit = Input::get('limit');
        $page = Input::get('page');

        $items = $postService->featured($page, $limit, $this->locale);

        return $this->response->withPaginate($items, new PostTransformer());
    }

}