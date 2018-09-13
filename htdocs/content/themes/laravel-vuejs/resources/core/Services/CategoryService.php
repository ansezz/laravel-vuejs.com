<?php

namespace Core\Services;

use Core\Models\Category;
use Core\Repository\TaxonomyRepository;
use Core\Transformers\CategoryTransformer;

class CategoryService
{

    /** @var TaxonomyRepository */
    protected $taxonomyRepository;

    protected $categoryTransformer;


    public function __construct(TaxonomyRepository $taxonomyRepository, CategoryTransformer $categoryTransformer)
    {
        $this->taxonomyRepository = $taxonomyRepository;
        $this->categoryTransformer = $categoryTransformer;
    }

    public function categories($locale = null)
    {
        if ($locale != null) {
            $categories = $this->taxonomyRepository
                ->getModel()
                ->category()
                ->whereHas('meta', function ($query) use ($locale) {
                    $query->where('meta_value', '=', $locale);
                })->get();
        } else {
            $categories = $this->taxonomyRepository
                ->getModel()
                ->category()
                ->get();
        }

        return ['categories' => $this->categoryTransformer->items($categories)];
    }

}