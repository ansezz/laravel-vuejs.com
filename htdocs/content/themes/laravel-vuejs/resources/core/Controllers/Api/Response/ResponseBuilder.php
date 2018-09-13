<?php

namespace Core\Controllers\Api\Response;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Response;
use Core\Models\BaseModelInterface;
use Core\Transformers\PostTransformer;
use Core\Transformers\TaxonomyTransformer;
use Core\Transformers\TransformerInterface;

class ResponseBuilder
{
    /** @var Response */
    protected $response;
    /** @var PostTransformer */
    protected $postTransformer;
    /** @var TaxonomyTransformer */
    protected $taxonomyTransformer;

    public function __construct(PostTransformer $postTransformer, TaxonomyTransformer $taxonomyTransformer)
    {
        $this->postTransformer = $postTransformer;
        $this->taxonomyTransformer = $taxonomyTransformer;
    }

    private function setHeader()
    {
        header('Content-Type: application/json');
    }

    public function json($data)
    {
        header('Content-Type: application/json');

        return $data;
    }

    public function withItems($postType, $result)
    {
        $this->setHeader();
        $results = [];

        if (!isset($result['posts'])) {
            $this->error(502, 'posts not found in results');
        }

        /** @var LengthAwarePaginator $posts */
        $posts = $result['posts'];

        if (isset($result['category'])) {
            $results['category'] = $this->taxonomyTransformer->item('category', $result['category']);
        }

        if (isset($result['tag'])) {
            $results['tag'] = $this->taxonomyTransformer->item('tag', $result['tag']);
        }

        if ('post' === $postType) {
            $results['total'] = $posts->total();
            $results['perPage'] = $posts->perPage();
            $results['currentPage'] = $posts->currentPage();
            $results['pages'] = $posts->lastPage();
            $results['posts'] = $this->postTransformer->items($posts);
        }

        return $results;
    }

    public function withItem($postType, $result)
    {
        $this->setHeader();

        if ('post' === $postType) {
            return $this->postTransformer->item($result);
        }

    }


    public function withArray($data)
    {
        $this->setHeader();
        return $data;
    }

    /**
     * Return a model not found error.
     *
     * @param $message
     * @return array
     */
    public function withNotFound($message)
    {
        $this->setHeader();
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
        $this->setHeader();
        status_header($status);

        return [
            'status' => $status,
            'message' => $message
        ];
    }
}