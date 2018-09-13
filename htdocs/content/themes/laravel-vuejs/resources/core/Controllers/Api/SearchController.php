<?php

namespace Core\Controllers\Api;


use Core\Controllers\Api\Response\ResponseBuilder;
use Core\Controllers\Api\Traits\Pagination;
use Core\Services\PostService;
use Core\Services\SearchService;

class SearchController extends ApiBaseController
{
    /** @var PostService */
    protected $postService;

    /** @var SearchService */
    protected $searchService;

    use Pagination;

    public function __construct(ResponseBuilder $responseBuilder, PostService $postService, SearchService $searchService)
    {
        parent::__construct($responseBuilder);

        $this->postService = $postService;
        $this->searchService = $searchService;
    }

    /**
     * @api {get} :local/search Search api
     * @apiName Search
     * @apiGroup Posts
     *
     * @apiParam {String} q search query
     *
     * @apiParam {Number} [page=1]
     * @apiParam {Number} [pages=1]
     * @apiParam {Number} [perPage=15]
     *
     * @apiSuccess {number} total total posts.
     * @apiSuccess {number} perPage per page.
     * @apiSuccess {number} page page.
     * @apiSuccess {number} pages pages.
     * @apiSuccess {Object[]} posts array of posts
     *
     */
    public function index($locale = null)
    {
        $query = $this->request->get('q');
        $this->setPaginationParams($this->request);

        $posts = $this->searchService->searchPosts($query, $this->page, $this->perPage, $locale);

        return $this->responseBuilder->withItems('post', $posts);
    }
}