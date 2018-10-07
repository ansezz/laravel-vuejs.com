<?php

namespace Core\Services;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Core\Models\Category;
use Core\Models\Post;
use Core\Models\Program;
use Core\Models\Taxonomy;
use Core\Models\Term;
use Core\Repository\PostRepository;
use Core\Repository\TaxonomyRepository;
use Core\Transformers\PostTransformer;

class PostService
{
    /** @var PostRepository */
    protected $postRepository;
    /** @var TaxonomyRepository */
    protected $taxonomyRepository;
    /** @var PostTransformer */
    protected $postTransformer;

    public function __construct(PostRepository $postRepository, TaxonomyRepository $taxonomyRepository, PostTransformer $postTransformer)
    {
        $this->postRepository = $postRepository;
        $this->postTransformer = $postTransformer;
        $this->taxonomyRepository = $taxonomyRepository;
    }

    private function hydrateWithRelatedByMainCategory(Post $post, $locale = null)
    {
        $category = $post->getTaxonomies()->get('category')->first();
        $post->related = $this->getByCategoryIdOrSlug($category['id'], 1, 10, $locale);

        return $post;
    }

    public function getByMetaValue($meta, $value)
    {
        $builder = $this->postRepository->getModel()->type('program')->published()->hasMeta($meta, $value);
        $post = $builder->first();

        if (null === $post) {
            throw new ModelNotFoundException();
        }

        return $post;
    }

    /**
     * @param $locale
     * @param $arg
     * @return array
     */
    public function getByIdOrSlug($arg, $locale = null)
    {
        $field = is_numeric($arg) ? Post::PRIMARY_KEY : Post::SLUG;
        /** @var Builder $builder */
        $builder = $this->postRepository->getModel()->where($field, urlencode($arg));


        if (null != $locale) {
            $builder = $builder->hasMeta(Post::LOCALE_KEY, $locale);
        }

        $post = $builder->first();

        if (null === $post) {
            throw new ModelNotFoundException();
        }

        $post = $this->hydrateWithRelatedByMainCategory($post, $locale);

        return $post;
    }

    /**
     * @param int $page
     * @param int $perPage
     * @param null $locale
     * @return array
     */
    public function all($page = 1, $perPage = 15, $locale = null)
    {
        /** @var Builder $builder */
        $builder = $this->postRepository
            ->getModel()
            ->published();

        if ($locale != null) {
            $builder = $builder->hasMeta(Post::LOCALE_KEY, $locale);
        }

        $posts = $builder->paginate($perPage, ['*'], 'page', $page);

        return ['items' => $posts];
    }

    /**
     * @param int $page
     * @param int $perPage
     * @param null $locale
     * @return array
     */
    public function getFeatured($page = 1, $perPage = 15, $locale = null)
    {
        /** @var Builder $builder */
        $builder = $this->postRepository
            ->getModel()
            ->published()
            ->hasMeta(Post::FEATURED_KEY, 1);

        if ($locale != null) {
            $builder = $builder->hasMeta(Post::LOCALE_KEY, $locale);
        }

        $posts = $builder->paginate($perPage, ['*'], 'page', $page);

        return ['items' => $posts];
    }

    public function getByCategoryIdOrSlug($arg, $page = 1, $perPage = 15, $locale = null)
    {
        $field = is_numeric($arg) ? 'id' : 'slug';
        /** @var Taxonomy */
        $taxonomy = $this->taxonomyRepository
            ->getModel()
            ->category()
            ->$field(urlencode($arg))
            ->first();


        if (null === $taxonomy) {
            throw new ModelNotFoundException();
        }

        /** @var Category $category */
        $category = $taxonomy->term->first();

        if (null === $category) {
            throw new ModelNotFoundException();
        }

        /** @var Builder $builder */
        $builder = $taxonomy->posts()->published();

        if ($locale != null) {
            $builder = $builder->hasMeta(Post::LOCALE_KEY, $locale);
        }

        /** @var LengthAwarePaginator $posts */
        $posts = $builder->paginate($perPage, ['*'], 'page', $page);

        return [
            'category' => $taxonomy,
            'items' => $posts,
        ];
    }

    public function getByTag($arg, $page = 1, $perPage = 15, $locale = null)
    {

        $tag = Term::where('slug', urlencode($arg))->first();

        if (null === $tag) {
            throw new ModelNotFoundException();
        }

        $taxonomy = $tag->taxonomy()->first();

        if (null === $taxonomy) {
            throw new ModelNotFoundException();
        }

        /** @var Builder $builder */
        $builder = $taxonomy->posts()->published();

        if ($locale != null) {
            $builder = $builder->hasMeta(Post::LOCALE_KEY, $locale);
        }

        /** @var LengthAwarePaginator $posts */
        $posts = $builder->paginate($perPage, ['*'], 'page', $page);

        return [
            'tag' => $taxonomy,
            'items' => $posts,
        ];
    }

    /**
     * @param $postType
     */
    public function setPostType($postType)
    {
        $this->postRepository->setPostType($postType);
    }
}