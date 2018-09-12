<?php

namespace Core\Exceptions;

use Throwable;

class ModelNotFound extends \Exception
{


    public function __construct($arg)
    {
        $this->message = 'Not Found';
        $this->code = 404;
        parent::__construct($this->message, $this->code);
    }

}