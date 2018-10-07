<?php

namespace Core\Transformers;

use Core\Models\Tag;

class TagTransformer implements TransformerInterface
{

    /**
     * @param Tag $tag
     * @return array
     */
    public function item($tag)
    {
        return [
            'id' => $tag->term_id,
            'name' => $tag->term->name,
            'slug' => $tag->term->slug,
        ];
    }

    public function items($tags)
    {
        $items = [];
        foreach ($tags as $item) {
            $items[] = $this->item($item);
        }

        return $items;
    }
}