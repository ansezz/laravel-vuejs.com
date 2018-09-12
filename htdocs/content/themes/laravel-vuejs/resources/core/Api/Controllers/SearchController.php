<?php

namespace Core\API\Controllers;

use Core\API\Services\PostService;
use Core\API\Transformers\PostTransformer;
use Themosis\Facades\Input;

class SearchController extends BaseController
{

    /**
     * @param PostService $postService
     * @return array
     */
    public function index(PostService $postService)
    {
        $s = Input::get('s');
        $limit = Input::get('limit');
        $page = Input::get('page');

        $items = $postService->search($s, $page, $limit, $this->locale);

        return $this->response->withCollection($items->posts, new PostTransformer());
    }

}