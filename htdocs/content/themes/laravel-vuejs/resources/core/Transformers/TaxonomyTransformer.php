<?php

namespace Core\Transformers;

use Illuminate\Support\Collection;
use Core\Models\BaseModelInterface;
use Core\Models\Post;
use Core\Models\Tag;
use Core\Models\Taxonomy;

/**
 * Class TaxonomyTransformer
 * @package Core\Transformers
 */
class TaxonomyTransformer
{
    /**
     * @param $type
     * @param Taxonomy $taxonomy
     * @return array
     */
    public static function item($type, Taxonomy $taxonomy)
    {
        return [
            'id' => $taxonomy->getKey(),
            'type' => $type,
            'name' => $taxonomy->term->name,
            'slug' => $taxonomy->term->slug,
            'description' => $taxonomy->term->description,
            'group' => $taxonomy->term->term_group,
            'total' => $taxonomy->count,
            'locale' => $taxonomy->getLocale()
        ];
    }
}