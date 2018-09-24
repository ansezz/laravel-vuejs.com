<?php

namespace Next\Themosis\Admin\Features;


use Next\Models\Menu;
use Next\Models\Post;
use Next\Services\PostService;
use Themosis\Facades\Field;
use Themosis\Facades\Input;
use Themosis\Facades\Page;
use Themosis\Facades\Section;

class SettingsFeature
{
    /** @var Page */
    public $globalSettingsPage;
    /** @var Page */
    public $menusSettingsPage;
    /** @var Page */
    public $linksSettingPage;
    /** @var Page */
    public $breakingNewsSettingPage;

    public function __construct()
    {
        $this->globalSettingsPage = self::makeGlobalSettingsPage();
        $this->menusSettingsPage = self::makeMenusSettingsPage();
        $this->linksSettingPage = self::makeLinksSettingsPage();
        $this->breakingNewsSettingPage = self::makeBreakingNewsSettingsPage();
    }

    private static function makeGlobalSettingsPage()
    {
        return Page::make('global_settings', 'Global Settings')->set([
            'capability' => 'manage_options',
            'icon' => 'dashicons-admin-site',
            'tabs' => true,
            'menu' => __("Global Settings")
        ]);
    }

    private static function makeMenusSettingsPage()
    {
        return Page::make('menus_settings', 'Menus Settings', 'global_settings')->set([
            'capability' => 'manage_options',
            'tabs' => true,
            'menu' => __("Menus Settings")
        ]);
    }

    private static function makeLinksSettingsPage()
    {
        return Page::make('links_settings', 'Links Settings', 'global_settings')->set([
            'capability' => 'manage_options',
            'tabs' => true,
            'menu' => __("Links Settings")
        ]);
    }

    private static function makeBreakingNewsSettingsPage()
    {
        return Page::make('breaking_news_settings', 'Breaking news', 'global_settings')->set([
            'capability' => 'manage_options',
            'tabs' => true,
            'menu' => __('Breaking News')
        ]);
    }

    private static function globalSettingsFields()
    {
        return [
            Field::text('website_title', ['title' => 'Website title']),
            Field::textarea('website_description', ['title' => 'Website description']),
            Field::media('header_logo', [
                'title' => 'Header Logo',
                'type' => ['image']
            ]),
            Field::media('footer_logo', [
                'title' => 'Footer Logo',
                'type' => ['image']
            ])
        ];
    }

    public function buildGlobalSettingsPage()
    {
        if (MultiLanguageFeature::isEnabled()) {
            $this->globalSettingsPage->addSections([
                Section::make('global_settings_fr', 'FR'),
                Section::make('global_settings_ar', 'AR')
            ]);

            $this->globalSettingsPage->addSettings([
                'global_settings_fr' => self::globalSettingsFields(),
                'global_settings_ar' => self::globalSettingsFields()
            ]);
        } else {
            $this->globalSettingsPage->addSections([
                Section::make('global_settings'),
            ]);

            $this->globalSettingsPage->addSettings([
                'global_settings' => self::globalSettingsFields()
            ]);
        }
    }

    private static function menusSettingsFields()
    {
        $menus = Menu::all();
        $selectionMenus = [];

        foreach ($menus as $menu) {
            $selectionMenus[] = [$menu->term()->first()->slug => $menu->term()->first()->name];
        }

        return [
            Field::select('main_menu', $selectionMenus, ['title' => 'Main Menu']),
            Field::select('navbar_menu', $selectionMenus, ['title' => 'NavBar Menu']),
            Field::select('hashtags_menu', $selectionMenus, ['title' => 'HashTags Menu']),
            Field::select('footer_menu', $selectionMenus, ['title' => 'Footer Menu']),
        ];
    }

    public function buildMenusSettingsPage()
    {
        if (MultiLanguageFeature::isEnabled()) {
            $this->menusSettingsPage->addSections([
                Section::make('menus_settings_fr', 'FR'),
                Section::make('menus_settings_ar', 'AR')
            ]);

            $this->menusSettingsPage->addSettings([
                'menus_settings_fr' => self::menusSettingsFields(),
                'menus_settings_ar' => self::menusSettingsFields(),
            ]);
        } else {
            $this->menusSettingsPage->addSections([
                Section::make('menus_settings'),
            ]);

            $this->menusSettingsPage->addSettings([
                'menus_settings' => self::menusSettingsFields()
            ]);
        }
    }

    private static function linksSettingsFields()
    {
        return [
            Field::text('facebook', ['title' => 'Facebook']),
            Field::text('twitter', ['title' => 'Twitter']),
            Field::text('youtube', ['title' => 'Youtube']),
            Field::text('instagram', ['title' => 'Instagram']),
            Field::text('play_store', ['title' => 'Play Store']),
            Field::text('apple_store', ['title' => 'Apple Store']),
        ];
    }

    public function buildLinksSettingsPage()
    {
        if (MultiLanguageFeature::isEnabled()) {
            $this->linksSettingPage->addSections([
                Section::make('links_settings_fr', 'FR'),
                Section::make('links_settings_ar', 'AR')
            ]);

            $this->linksSettingPage->addSettings([
                'links_settings_fr' => self::linksSettingsFields(),
                'links_settings_ar' => self::linksSettingsFields(),
            ]);
        } else {
            $this->linksSettingPage->addSections([
                Section::make('links_settings'),
            ]);

            $this->linksSettingPage->addSettings([
                'links_settings' => self::linksSettingsFields()
            ]);
        }
    }

    public function buildBreakingNewsSettingsPage()
    {
        if (MultiLanguageFeature::isEnabled()) {
            $this->breakingNewsSettingPage->addSections([
                Section::make('breaking_news_settings_fr', 'FR'),
                Section::make('breaking_news_settings_ar', 'AR')
            ]);

            $this->breakingNewsSettingPage->addSettings([
                'breaking_news_settings_fr' => self::breakingNewsSettingsFields(),
                'breaking_news_settings_ar' => self::breakingNewsSettingsFields(),
            ]);
        } else {
            $this->breakingNewsSettingPage->addSections([
                Section::make('breaking_news_settings'),
            ]);

            $this->breakingNewsSettingPage->addSettings([
                'breaking_news_settings' => self::breakingNewsSettingsFields()
            ]);
        }
    }

    private static function breakingNewsSettingsFields()
    {

        // Get local from tab params
        $locale = 'fr';
        if (Input::has('tab')) {
            $tab = Input::get('tab');
            $explode_tab = explode('_', $tab);
            $locale = $explode_tab[count($explode_tab) - 1];
        }

        // Get published posts
        $post = new Post();
        $post->setPostType('post');
        $builder = $post->published();
        $builder = $builder->hasMeta('locale', $locale);
        $articles = $builder->get();

        $selectionArticles = [];

        foreach ($articles as $article) {
            $selectionArticles[] = [$article->ID => $article->post_title];
        }

        return [
            Field::checkbox('is_active', 'Active'),
            Field::select('selected_post', $selectionArticles, ['title' => 'NavBar Menu'])
        ];
    }

}