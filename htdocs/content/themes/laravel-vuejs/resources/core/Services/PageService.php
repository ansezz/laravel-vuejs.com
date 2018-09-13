<?php

namespace Core\Services;


use Core\Models\Page;
use Core\Repository\PageRepository;
use Core\Repository\TaxonomyRepository;
use Core\Transformers\PageTransformer;
use Illuminate\Database\Eloquent\Builder;

class PageService
{

    protected $pageTransformer;
    protected $pageRepository;
    protected $taxonomyRepository;

    public function __construct(PageTransformer $pageTransformer, TaxonomyRepository $taxonomyRepository, PageRepository $pageRepository)
    {
        $this->pageTransformer = $pageTransformer;
        $this->taxonomyRepository = $taxonomyRepository;
        $this->pageRepository = $pageRepository;
    }

    public function getAll($page = 1, $perPage = 15, $locale = null)
    {

        /** @var Builder $builder */
        $builder = $this->pageRepository
            ->getModel()
            ->published();

        if ($locale !== null) {
            $builder = $builder->hasMeta('locale', $locale);
        }

        $pages = $builder->paginate($perPage, ['*'], 'page', $page);

        return ['items' => $pages];
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