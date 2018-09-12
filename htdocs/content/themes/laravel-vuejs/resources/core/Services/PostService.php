<?php

namespace Core\API\Services;

use Core\Models\Post;

class PostService extends Service
{
    const POST_TYPES = ['post'];

    /**
     * PostService constructor.
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        parent::__construct($post);
    }


    /**
     * @param $arg
     * @param $locale
     * @return mixed
     */
    public function findByIdOrSlug($arg, $locale)
    {
        return $this->model
            ->postType(self::POST_TYPES)
            ->setLocale($locale)
            ->findByIdOrSlug($arg);
    }

    /**
     * @param $s
     * @param $page
     * @param $limit
     * @param $locale
     * @return \WP_Query
     */
    public function search($s, $page, $limit, $locale)
    {
        return $this->model
            ->postType(self::POST_TYPES)
            ->setLocale($locale)
            ->paginate($page, $limit)
            ->search($s);
    }

    /**
     * @param $page
     * @param $limit
     * @param $locale
     * @return \WP_Query
     */
    public function paginate($page, $limit, $locale)
    {
        return $this->model
            ->postType(self::POST_TYPES)
            ->setLocale($locale)
            ->paginate($page, $limit)
            ->get();
    }

    /**
     * @param $arg
     * @param $page
     * @param $limit
     * @param $locale
     * @return mixed
     */
    public function findByCategoryIdOrSlug($arg, $page, $limit, $locale)
    {
        return $this->model
            ->postType(self::POST_TYPES)
            ->setLocale($locale)
            ->paginate($page, $limit)
            ->findByCategoryIdOrSlug($arg);
    }

    /**
     * @param $page
     * @param $limit
     * @param $locale
     * @return \WP_Query
     */
    public function featured($page, $limit, $locale)
    {
        return $this->model
            ->postType(self::POST_TYPES)
            ->paginate($page, $limit)
            ->setMetas([Post::FEATURED => 1])
            ->setLocale($locale)
            ->get();
    }

}