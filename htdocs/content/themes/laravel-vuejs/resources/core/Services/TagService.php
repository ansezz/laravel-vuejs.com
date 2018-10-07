<?php

namespace Core\Services;

use Core\Models\Tag;
use Core\Repository\TaxonomyRepository;
use Core\Transformers\TagTransformer;

class TagService
{

    /** @var TaxonomyRepository */
    protected $taxonomyRepository;

    protected $tagTransformer;


    public function __construct(TaxonomyRepository $taxonomyRepository, TagTransformer $tagTransformer)
    {
        $this->taxonomyRepository = $taxonomyRepository;
        $this->tagTransformer = $tagTransformer;
    }

    public function tags($locale = null)
    {
        $tags = $this->taxonomyRepository
            ->getModel()
            ->tag()
            ->get();

        return ['tags' => $this->tagTransformer->items($tags)];
    }

}