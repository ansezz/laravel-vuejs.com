<?php

namespace Core\API\Services;

use Core\API\Transformers\TermTransformer;

class TermService
{

    protected $termTransformer;

    /**
     * TermService constructor.
     */
    public function __construct()
    {
        $this->termTransformer = new TermTransformer();
    }

    /**
     * @param $id
     * @return array
     */
    public function getPostCategory($id)
    {
        return array_map(function ($item) {
            return $this->termTransformer->item($item);
        }, $this->getCategory($id));
    }

    /**
     * @param $id
     * @return array
     */
    public function getPostTags($id)
    {
        return array_map(function ($item) {
            return $this->termTransformer->item($item);
        }, $this->getTags($id));
    }

    /**
     * @param $id
     * @return array
     */
    public function getPostAuthor($id)
    {
        return [
            'id' => get_the_author_meta('ID', $id),
            'display_name' => get_the_author_meta('display_name', $id),
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function getCategory($id)
    {
        $categories = get_the_category($id);
        if (is_array($categories)) {
            return $categories;
        } else {
            return [];
        }
    }

    /**
     * @param $id
     * @return array
     */
    public function getTags($id)
    {
        $tags = get_the_tags($id);
        if (is_array($tags)) {
            return $tags;
        } else {
            return [];
        }
    }

}
