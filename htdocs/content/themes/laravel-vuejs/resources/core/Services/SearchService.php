<?php

namespace Core\Services;


use Core\Models\Post;
use Core\Repository\PostRepository;

class SearchService
{
    /** @var PostRepository */
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function searchPosts($query, $page = 1, $perPage = 15, $locale = null)
    {
        $builder = $this->postRepository->getModel()
            ->published();

        if (null != $locale) {
            $builder = $builder->hasMeta(Post::LOCALE_KEY, $locale);
        }

        $builder = $builder
            ->where(Post::TITLE, 'like', "%{$query}%")
            ->orWhere(Post::CONTENT, 'like', "%{$query}%");

        $posts = $builder->paginate($perPage, ['*'], 'page', $page);

        return ['items' => $posts];
    }
}
