<?php

namespace Core\API\Controllers;

use Core\Response;
use Themosis\Facades\Route;

class BaseController
{

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var Response
     */
    protected $response;

    /**
     * BaseController constructor.
     * @param Route $request
     * @param Response $response
     */
    public function __construct(Route $request, Response $response)
    {
        $params = Route::current()->parameters();

        if (isset($params['locale'])) {
            $this->locale = $params['locale'];
            Route::current()->forgetParameter('locale');
        }

        $this->response = $response;
    }

}