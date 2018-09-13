<?php

namespace Core\Controllers\Api;


use Illuminate\Http\Request;
use Core\Controllers\Api\Response\ResponseBuilder;

class ApiBaseController
{
    /** @var Request */
    protected $request;

    protected $responseBuilder;

    public function __construct(ResponseBuilder $responseBuilder)
    {
        $this->responseBuilder = $responseBuilder;
        $this->request = Request::createFromGlobals();
    }
}