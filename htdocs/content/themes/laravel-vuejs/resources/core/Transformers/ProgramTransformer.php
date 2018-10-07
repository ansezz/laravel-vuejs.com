<?php

namespace Core\Transformers;

use Core\Helper;
use Core\Models\Attachment;
use Core\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Core\Models\Program;

/**
 * Class ProgramTransformer
 * @package Core\Transformers
 */
class ProgramTransformer implements TransformerInterface
{
    /** @var UserTransformer */
    protected $userTransformer;

    public function __construct(UserTransformer $userTransformer)
    {
        $this->userTransformer = $userTransformer;
    }

    /**
     * @param Program $post
     * @return array
     */
    public function item(Program $post)
    {
        $taxonomies = $post->getTaxonomies();

        return [
            'id' => $post->getKey(),
            'title' => $post->getTitle(),
            'source-id' => $post->meta->sourceId,
            'author-name' => $post->meta->authorName,
            'slug' => urldecode($post->getSlug()),
            'type' => $post->getPostType(),
            'content' => $post->getContent(),
            'subtitle' => $post->meta->diffusionDate,
            'image' => Helper::staticUrl($post->getImage()),
            'image-slide' => Helper::staticUrl($post->getImageSlideUrl()),
            'locale' => $post->meta->locale,
            'description' => $post->meta->description,
            'author' => $this->userTransformer->item($post->getAuthor()),
            'main-category' => $post->getMainCategory(),
            'categories' => isset($taxonomies['category']) ? $taxonomies['category'] : [],
            'tags' => isset($taxonomies['tag']) ? $taxonomies['tag'] : [],
            'keywords' => $post->getKeywords(),
            'keywords-str' => $post->getKeywordsStr(),
            'format' => $post->getFormat(),
            'status' => $post->getStatus(),
            'created' => $post->getCreatedAt()->format('Y-m-d H:m:i'),
            'updated' => $post->getUpdatedAt()->format('Y-m-d H:m:i')
        ];
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