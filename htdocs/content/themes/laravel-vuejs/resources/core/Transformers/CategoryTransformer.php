<?php

namespace Core\Transformers;

class CategoryTransformer implements TransformerInterface
{

    /**
     * @param Category $category
     * @return array
     */
    public function item($category)
    {
        return [
            'id' => $category->term_id,
            'name' => $category->term->name,
            'slug' => $category->term->slug,
        ];
    }

    public function items($categories)
    {
        $items = [];
        foreach ($categories as $item) {
            $items[] = $this->item($item);
        }

        return $items;
    }
}