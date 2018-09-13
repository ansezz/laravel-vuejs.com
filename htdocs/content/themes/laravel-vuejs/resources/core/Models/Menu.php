<?php

namespace Core\Models;


class Menu extends Taxonomy
{
    /**
     * @var string
     */
    protected $taxonomy = 'nav_menu';

    /**
     * @var array
     */
    protected $with = ['term', 'items'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function items()
    {
        return $this->belongsToMany(
            MenuItem::class, 'term_relationships', 'term_taxonomy_id', 'object_id'
        )->orderBy('menu_order');
    }
}