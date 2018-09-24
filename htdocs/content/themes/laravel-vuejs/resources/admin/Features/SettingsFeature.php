<?php

namespace Theme\Admin\Features;

use Core\Models\Menu;
use Themosis\Facades\Config;
use Themosis\Facades\Field;
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

    public $supported_locale;

    public function __construct()
    {
        $this->globalSettingsPage = self::makeGlobalSettingsPage();
        $this->menusSettingsPage = self::makeMenusSettingsPage();
        $this->linksSettingPage = self::makeLinksSettingsPage();
        $this->supported_locale = Config::get('laravelvuejs.supported_locale');
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
        $sections = [];
        $settings = [];

        foreach ($this->supported_locale as $item) {
            $sections[] = Section::make('global_settings_' . $item['code'], $item['title']);
            $settings['global_settings_' . $item['code']] = self::globalSettingsFields();
        }

        $this->globalSettingsPage->addSections($sections);

        $this->globalSettingsPage->addSettings($settings);
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
        $sections = [];
        $settings = [];

        foreach ($this->supported_locale as $item) {
            $sections[] = Section::make('menus_settings_' . $item['code'], $item['title']);
            $settings['menus_settings_' . $item['code']] = self:: menusSettingsFields();
        }


        $this->menusSettingsPage->addSections($sections);

        $this->menusSettingsPage->addSettings($settings);

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
        $settings = [];
        $sections = [];

        $sections[] = Section::make('links_settings', 'Social Links');
        $settings['links_settings'] = self::linksSettingsFields();

        $this->linksSettingPage->addSections($sections);

        $this->linksSettingPage->addSettings($settings);
    }
}