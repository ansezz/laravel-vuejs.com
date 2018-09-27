<?php

namespace Core\Transformers;

use Core\Helper;
use Core\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class PostTransformers
 * @package Core\Transformers
 */
class PostTransformer implements TransformerInterface
{
    /** @var UserTransformer */
    protected $userTransformer;

    public function __construct(UserTransformer $userTransformer)
    {
        $this->userTransformer = $userTransformer;
    }

    /**
     * @param Post $post
     * @return array
     */
    public function item(Post $post)
    {


        $taxonomies = $post->getTaxonomies();


        $result = [
            'id' => $post->getKey(),
            'title' => $post->getTitle(),
            'slug' => urldecode($post->getSlug()),
            'type' => $post->getPostType(),
            'excerpt' => $post->getExcerpt(),
            'content' => $post->getContent(),
            // @TODO : config static url
            'image' => $post->getImage(),//Helper::staticUrl($post->getImage()),
            'author' => $this->userTransformer->item($post->getAuthor()),
            'main-category' => $post->getMainCategory(),
            'categories' => isset($taxonomies['category']) ? $taxonomies['category'] : [],
            'tags' => isset($taxonomies['tag']) ? $taxonomies['tag'] : [],
            'keywords' => $post->getKeywords(),
            'keywords-str' => $post->getKeywordsStr(),
            'format' => $post->getFormat(),
            'locale' => $post->getLocale(),
            'status' => $post->getStatus(),
            'related' => isset($post->related['posts']) ? $this->items($post->related['posts']) : [],
            'created' => $post->getCreatedAt()->format('Y-m-d H:m:i'),
            'updated' => $post->getUpdatedAt()->format('Y-m-d H:m:i')
        ];

        switch ($result['type']) {
            case 'video':
                $result['video_url'] = $post->meta->video_url;
                break;
            case 'qa':
                $result['resolved'] = (bool)$post->meta->RESOLVED;
                $result['answer'] = $post->meta->answer;
                $result['source'] = $post->meta->source;
                break;
        }

        return $result;
    }

    public function items(LengthAwarePaginator $posts)
    {
        $items = [];
        foreach ($posts->items() as $item) {
            $items[] = $this->item($item);
        }

        return $items;
    }
}