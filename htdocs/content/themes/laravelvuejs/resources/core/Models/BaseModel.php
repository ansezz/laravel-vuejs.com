<?php

namespace Core\Models;


use Themosis\Facades\Config;

class BaseModel
{

    const FEATURED = 'FEATURED';
    const LOCALE = 'LOCALE';

    /**
     * @var
     */
    protected $args = [];

    /**
     * PostService constructor
     *
     * @param array $args
     * @return \WP_Query
     */
    public function get(array $args = [])
    {
        $result = new \WP_Query(
            $this->args = array_merge_recursive($this->args, $args)
        );

        $this->args = [];

        return $result;
    }

    /**
     * @param array $args
     * @return \WP_Query
     */
    public function getPosts(array $args = [])
    {
        $result = new \WP_Query(
            array_merge_recursive($this->args, $args)
        );

        $this->args = [];

        return $result;
    }

    /**
     * Set meta for the query.
     *
     * @param $meta
     * @return $this
     */
    public function setMetas($meta)
    {
        $metaQuery = collect($meta)->map(function ($value, $key) {
            return [
                'key' => $key,
                'value' => $value
            ];
        });

        $this->args = array_merge_recursive($this->args, ['meta_query' => $metaQuery->toArray()]);

        return $this;
    }


    /**
     * @param $s
     * @param array $type
     * @return \WP_Query
     */
    public function search($s, array $type = ['post'])
    {
        return $this
            ->postType($type)
            ->get(
                [
                    's' => esc_html($s),
                    'orderby' => 'date',
                ]
            );
    }

    /**
     * Set the post type.
     *
     * @param mixed $postType
     * @return $this
     */
    public function postType($postType)
    {
        $this->args = array_merge_recursive($this->args, ['post_type' => $postType]);

        return $this;
    }


    /**
     * Paginate the result.
     *
     * @param int $page
     * @param $limit
     * @return $this
     */
    public function paginate($page = 1, $limit = null)
    {
        $this->args = array_merge_recursive($this->args, [
            'posts_per_page' => !empty($limit) ?: Config::get('api.posts_limit'),
            'paged' => !empty($page) ? $page : 1,
            'page' => !empty($page) ? $page : 1,
        ]);
        return $this;
    }

    /**
     * @param $args
     * @return $this
     */
    protected function setArgs($args)
    {
        $this->args = array_merge_recursive($this->args, $args);

        return $this;
    }

    /**
     * @param $locale
     * @return BaseModel
     */
    public function setLocale($locale)
    {
        return $this->setMetas([self::LOCALE => $locale]);
    }


}
