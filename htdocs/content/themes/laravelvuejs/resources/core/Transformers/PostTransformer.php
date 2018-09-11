<?php

namespace Core\API\Transformers;

use Core\API\Services\TermService;

class PostTransformer extends Transformer
{

    protected $termService;

    public function __construct()
    {
        $this->termService = new TermService();
    }

    /**
     * Transform a post object.
     *
     * @param $item
     * @return array
     */
    public function item($item)
    {
        return [
            'id' => $item->ID,
            'type' => $item->post_type,
            'title' => $item->post_title,
            'slug' => $item->post_name,
            'excerpt' => $item->post_excerpt,
            'content' => $item->post_content,
            'created' => $item->post_date,
            'modified' => $item->post_modified,
            'categories' => $this->termService->getPostCategory($item->ID),
            'tags' => $this->termService->getPostTags($item->ID),
            'author' => $this->termService->getPostAuthor($item->post_author),
        ];
    }


    /**
     * @param $result
     * @return array
     */
    public function paginate($result)
    {
        $post_query = $result;
        if (isset($result->post_query)) {
            $post_query = $result->post_query;
        }

        $return = parent::paginate($post_query);

        $termTransformer = new TermTransformer();

        if (isset($result->term)) {
            $return['term'] = $termTransformer->item($result->term);
        }

        return $return;
    }

}
