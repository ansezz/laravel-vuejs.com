<?php


namespace Core\Controllers\Api;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Core\Controllers\Api\Response\ResponseBuilder;
use Core\Services\PageService;

class PageController extends ApiBaseController
{

    protected $pageService;
    protected $responseBuilder;

    public function __construct(PageService $pageService, ResponseBuilder $responseBuilder)
    {
        parent::__construct($responseBuilder);
        $this->pageService = $pageService;
    }

    public function index($locale = null)
    {
        try {
            $pages = $this->pageService->getAll($locale);

            return $this->responseBuilder->json($pages);
        } catch (ModelNotFoundException $e) {
            return $this->responseBuilder->withNotFound('not found');
        }
    }

    public function getPageByIdOrSlug($locale = null, $arg)
    {
        try {
            $page = $this->pageService->getByIdOrSlug($locale, $arg);

            if ($page === false) {
                return $this->responseBuilder->withNotFound('Not found');
            }
            return $this->responseBuilder->json($page);
        } catch (ModelNotFoundException $e) {
            return $this->responseBuilder->withNotFound('not found');
        }
    }
}