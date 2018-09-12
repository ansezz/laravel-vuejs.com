<?php

namespace Core;

class Response
{
    /**
     * Set the response type to json.
     *
     * Response constructor.
     */
    public function __construct()
    {
        header('Content-Type: application/json');
    }

    /**
     * Respond with array.
     *
     * @param $data
     * @return array
     */
    public function withArray($data)
    {
        return $data;
    }

    /**
     * Respond with a single item.
     *
     * @param $item
     * @param $transformer
     * @return array
     */
    public function withItem($item, $transformer)
    {
        return ['data' => $transformer->item($item)];
    }

    /**
     * Transformer a collection of items.
     *
     * @param $items
     * @param $transformer
     * @return array
     */
    public function withCollection($items, $transformer)
    {
        return ['data' => $transformer->collection($items)];
    }


    /**
     * Transformer a paginate of items.
     *
     * @param $items
     * @param $transformer
     * @return array
     */
    public function withPaginate($result, $transformer)
    {
        return ['data' => $transformer->paginate($result)];
    }

    /**
     * Return a model not found error.
     *
     * @param $message
     * @return array
     */
    public function withNotFound($message)
    {
        return $this->error(404, $message);
    }

    /**
     * Return a generic error response.
     *
     * @param $status
     * @param $message
     * @return array
     */
    public function error($status, $message)
    {
        status_header($status);

        return [
            'status' => $status,
            'detail' => $message
        ];
    }
}
