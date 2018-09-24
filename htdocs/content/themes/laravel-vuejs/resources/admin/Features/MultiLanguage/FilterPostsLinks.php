<?php

namespace Theme\Admin\Features\MultiLanguage;

class FilterPostsLinks
{
    /**
     * Post type
     *
     * @var string
     */
    protected $postType;

    public function __construct()
    {
        $this->postType = isset($_GET['post_type']) ? esc_html($_GET['post_type']) : 'post';
    }

    /**
     *
     * @param string $views
     * @return string
     */
    public function filter($views)
    {
        return $this->links($views);
    }

    /**
     * Get the posts count for a given locale
     *
     * @param string $locale
     * @return integer
     */
    protected function posts($locale)
    {
        return (new \WP_Query([
            'post_type' => $this->postType,
            'meta_key' => 'locale',
            'meta_value' => $locale
        ]))->found_posts;
    }

    /**
     * Return 'current' as current page is on
     *
     * @param string $locale
     * @return string
     */
    protected function attrs($locale)
    {
        return (isset($_GET['locale']) && $_GET['locale'] == $locale) ? ' class="current"' : '';
    }

    /**
     * Merge new 'french' and 'arabic' links with older links.
     *
     * @param string $views
     * @return string
     */
    protected function links($views)
    {
        $views['published_fr'] = $this->link('French', 'fr');
        $views['published_ar'] = $this->link('Arabic', 'ar');

        return $views;
    }

    /**
     * Format the link.
     *
     * @param string $title
     * @param string $locale
     * @return string
     */
    protected function link($title, $locale)
    {
        return sprintf(
            '<a href="%s"' . $this->attrs($locale) . '>' . $title . ' Posts <span class="count">(%d)</span></a>',
            admin_url("edit.php?post_type=$this->postType&locale=$locale"),
            $this->posts($locale)
        );
    }
}
