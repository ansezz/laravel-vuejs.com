<?php

namespace Core\Models;

use Core\Exceptions\ModelNotFound;

class Post extends BaseModel
{
    /**
     * @param $arg
     * @return \WP_Query
     * @throws ModelNotFound
     */
    public function findByIdOrSlug($arg)
    {
        $args = is_numeric($arg) ? ['p' => $arg] : ['name' => $arg];

        $result = $this->get($args);

        if ($result->found_posts) {
            return $result->posts[0];
        }

        throw  new  ModelNotFound($arg);
    }

    /**
     * @param $arg
     * @return object
     * @throws ModelNotFound
     */
    public function findByCategoryIdOrSlug($arg)
    {
        $field = is_numeric($arg) ? 'id' : 'slug';
        $category = get_term_by($field, $arg, 'category');
        if ($category) {
            $result = $this->get(['cat' => $category->term_id]);
            return (object)[
                'post_query' => $result,
                'term' => $category
            ];
        }

        throw  new  ModelNotFound($arg);
    }
}
