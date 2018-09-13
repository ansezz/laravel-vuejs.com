<?php

namespace Core\Services;


use Core\Models\Page;
use Core\Repository\TaxonomyRepository;
use Core\Transformers\PageTransformer;
use Illuminate\Database\Eloquent\Builder;

class PageService
{

    protected $pageTransformer;
    protected $taxonomyRepository;

    public function __construct(PageTransformer $pageTransformer, TaxonomyRepository $taxonomyRepository)
    {
        $this->pageTransformer = $pageTransformer;
        $this->taxonomyRepository = $taxonomyRepository;
    }

    public function getAll($locale)
    {

        $pages = Page::where('post_status', 'publish')
            ->hasMeta('locale', $locale)
            ->get();

        return $this->pageTransformer->items($pages);
    }

    public function getByIdOrSlug($locale, $arg)
    {

        $field = is_numeric($arg) ? 'ID' : 'post_name';

        $page = Page::where('post_status', 'publish')
            ->where($field, $arg)
            ->hasMeta('locale', $locale)
            ->first();
        if ($page == null) {
            return false;
        }
        return $this->pageTransformer->item($page);
    }
}