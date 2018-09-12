<?php

namespace Core\API\Controllers;

use Core\API\Services\PostService;
use Core\API\Transformers\PostTransformer;
use Core\API\Transformers\TermTransformer;
use Core\Exceptions\ModelNotFound;
use Themosis\Facades\Input;

class APIController extends BaseController
{

    /**
     * @return array
     */
    public function status()
    {
        $res = [
            'active' => true,
        ];
        return $this->response->withArray($res);
    }
}