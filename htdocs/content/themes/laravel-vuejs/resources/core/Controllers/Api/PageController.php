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
        $perPage = $this->request->get('perPage') === null ? 15 : $this->request->get('perPage');
        $page = $this->request->get('page') === null ? 1 : $this->request->get('page');

        try {
            $pages = $this->pageService->getAll($page, $perPage, $locale);
        } catch (ModelNotFoundException $e) {
            return $this->responseBuilder->withNotFound('not found');
        }

        return $this->responseBuilder->withItems('page', $pages);
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