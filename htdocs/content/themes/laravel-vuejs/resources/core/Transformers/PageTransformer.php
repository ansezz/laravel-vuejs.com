<?php

namespace Core\Transformers;

use Core\Helper;
use Core\Models\Page;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class PostTransformers
 * @package Core\Transformers
 */
class PageTransformer implements TransformerInterface
{
    /**
     * @param Page $page
     * @return array
     */
    public function item(Page $page)
    {
        return [
            'id' => $page->getKey(),
            'title' => $page->getTitle(),
            'slug' => urldecode($page->getSlug()),
            'type' => $page->getPostType(),
            'excerpt' => $page->getExcerpt(),
            'content' => $page->getContent(),
            'image' => Helper::staticUrl($page->getImage()),
            'main-category' => $page->getMainCategory(),
            'keywords' => $page->getKeywords(),
            'keywords-str' => $page->getKeywordsStr(),
            'format' => $page->getFormat(),
            'locale' => $page->getLocale(),
            'status' => $page->getStatus(),
            'created' => $page->getCreatedAt()->format('Y-m-d H:m:i'),
            'updated' => $page->getUpdatedAt()->format('Y-m-d H:m:i')
        ];
    }

    public function items($pages)
    {
        $items = [];
        foreach ($pages as $item) {
            $items[] = $this->item($item);
        }

        return $items;
    }
}