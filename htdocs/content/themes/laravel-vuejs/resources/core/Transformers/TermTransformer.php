<?php

namespace Core\API\Transformers;

class TermTransformer extends Transformer
{

    /**
     * Transform a post object.
     *
     * @param $item
     * @return array
     */
    public function item($item)
    {
        return [
            'id' => $item->term_id,
            'name' => $item->name,
            'slug' => $item->slug,
            'description' => $item->description,
            'count' => $item->count
        ];
    }

}
