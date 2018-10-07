<?php


namespace Core\Models\Builder;


use Illuminate\Database\Eloquent\Builder;

class TaxonomyBuilder extends Builder
{
    /**
     * @return TaxonomyBuilder
     */
    public function category()
    {
        return $this->where('taxonomy', 'category');
    }

    /**
     * @return TaxonomyBuilder
     */
    public function tag()
    {
        return $this->where('taxonomy', 'post_tag');
    }


    /**
     * @return TaxonomyBuilder
     */
    public function menu()
    {
        return $this->where('taxonomy', 'nav_menu');
    }

    /**
     * @param string $name
     * @return TaxonomyBuilder
     */
    public function name($name)
    {
        return $this->where('taxonomy', $name);
    }

    /**
     * @param string $slug
     * @return TaxonomyBuilder
     */
    public function slug($slug = null)
    {
        if (!is_null($slug) && !empty($slug)) {
            return $this->whereHas('term', function ($query) use ($slug) {
                $query->where('slug', $slug);
            });
        }
        return $this;
    }

    public function id($id = null)
    {
        if (!is_null($id) && !empty($id)) {
            return $this->whereHas('term', function ($query) use ($id) {
                $query->where('term_id', $id);
            });
        }
        return $this;
    }

    /**
     * @param null $slug
     * @return TaxonomyBuilder
     */
    public function term($slug = null)
    {
        return $this->slug($slug);
    }
}