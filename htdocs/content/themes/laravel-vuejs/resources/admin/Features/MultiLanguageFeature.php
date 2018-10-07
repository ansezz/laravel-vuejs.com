<?php

namespace Theme\Admin\Features;

use Core\Models\Post;
use Illuminate\Support\Facades\Log;
use Theme\Admin\Builder\PermalinkBuilder;
use Theme\Admin\Features\MultiLanguage\FilterPostsLinks;
use Theme\Admin\Features\MultiLanguage\FilterPostsQuery;
use Themosis\Facades\Action;
use Themosis\Facades\Config;
use Themosis\Facades\Field;
use Themosis\Facades\Filter;

class MultiLanguageFeature
{

    public static function createLanguageField()
    {
        $locales = Config::get('laravelvuejs.supported_locale');

        $values = [];
        foreach ($locales as $locale) {
            $values[] = [$locale['code'] => $locale['name']];
        }

        return Field::select(Post::LOCALE_KEY, $values, ['title' => 'Language']);
    }

    public static function createLocaleField()
    {
        $locales = Config::get('laravelvuejs.supported_locale');

        $values = [];
        foreach ($locales as $locale) {
            $values[] = [$locale['code'] => $locale['name']];
        }

        return Field::select(Post::LOCALE_KEY, $values, ['title' => 'Locale']);
    }

    public static function customizeGetPostPermalink()
    {

        add_filter('get_sample_permalink_html', function ($permalink, $postId) {
            return PermalinkBuilder::build($postId, $permalink);
        }, 10, 2);

    }

    public static function customizeGetPosts()
    {
        $filterLinks = new FilterPostsLinks();

        Filter::add('views_edit-post', [$filterLinks, 'filter']);

        $filterQuery = new FilterPostsQuery();
        Action::add('pre_get_posts', [$filterQuery, 'run']);
    }

    public static function customizeGetTaxonomies()
    {
        Filter::add('manage_edit-category_columns', function ($columns) {
            $columns['locale'] = 'Language';

            return $columns;
        });

        Filter::add('manage_category_custom_column', function ($content, $column_name, $term_id) {
            switch ($column_name) {
                case 'locale':
                    $locale = get_term_meta($term_id, 'locale', true);
                    $content = $locale;
                    break;
            }
            return $content;
        }, 10, 3);
    }
}