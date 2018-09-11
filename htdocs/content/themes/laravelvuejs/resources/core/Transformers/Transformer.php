<?php

namespace Core\API\Transformers;


abstract class Transformer
{

    public function collection($items)
    {
        return collect($items)->map(function ($item) {
            return $this->item($item);
        })->all();
    }

    abstract public function item($item);


    /**
     * @param $post_query
     * @return array
     */
    public function paginate($post_query)
    {
        return [
            'count' => (int)$post_query->post_count,
            'count_total' => (int)$post_query->found_posts,
            'pages' => (int)$post_query->max_num_pages,
            'posts' => $this->collection($post_query->posts),
        ];
    }
}