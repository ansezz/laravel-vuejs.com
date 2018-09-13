<?php


namespace Core\Controllers\Api\Traits;


use Illuminate\Http\Request;

trait Pagination
{
    public $perPage = 15;
    public $page = 1;

    public function setPaginationParams(Request $request)
    {
        if (null != $request->get('perPage')) {
            $this->perPage = $request->get('perPage');
        }

        if (null != $request->get('page')) {
            $this->page = $request->get('page');
        }

    }
}