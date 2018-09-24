<?php

namespace Theme\Admin\Features\MultiLanguage;

use WP_Query;

class FilterPostsQuery
{
    /**
     * Query the posts based on the locale fetched from get params
     *
     * @param WP_Query $query
     * @return void
     */
    protected function applyLocale(WP_Query $query)
    {
        if (isset($_GET['locale']) && in_array($_GET['locale'], ['ar', 'fr'])) {
            $this->query($query, esc_html($_GET['locale']));
        }
    }

    /**
     * Alter the query with locale meta
     * @param $query
     * @param $locale
     */
    protected function query(WP_Query $query, $locale)
    {
        $query->set('meta_key', 'locale');
        $query->set('meta_value', $locale);
    }


    /**
     * Run the query
     *
     * @param $query
     */
    public function run(WP_Query $query)
    {
        if ($query->is_main_query()) {
            return $this->applyLocale($query);
        }
    }
}
