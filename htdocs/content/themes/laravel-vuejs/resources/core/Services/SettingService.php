<?php

namespace Core\API\Services;


class SettingService
{
    const GLOBAL_SETTINGS_LOCALE_KEY = 'global_settings_%s';

    const MENUS_SETTINGS_LOCALE_KEY = 'menus_settings_%s';

    const LINKS_SETTINGS_LOCALE_KEY = 'links_settings_%s';

    public function __construct()
    {
    }

    private function getAttachment($attachmentId)
    {
        return wp_get_attachment_image_url($attachmentId);
    }

    public function getGlobalSettings($locale = null)
    {
        $optionKey = sprintf(self::GLOBAL_SETTINGS_LOCALE_KEY, $locale);

        $settings = \Option::get($optionKey);

        if ($headerLogo = $this->getAttachment($settings['header_logo'])) {
            $settings['header_logo'] = $headerLogo;
        }

        if ($footerLogo = $this->getAttachment($settings['footer_logo'])) {
            $settings['footer_logo'] = $footerLogo;
        }

        return $settings;
    }

    public function getMenusSettings($locale = null)
    {
        $optionKey = sprintf(self::MENUS_SETTINGS_LOCALE_KEY, $locale);

        $settings = \Option::get($optionKey);

        if (is_array($settings)) {
            foreach ($settings as $key => $value) {
                $menu = wp_get_nav_menu_items($value);
                $settings[$key] = $menu;
            }
        }

        return $settings;
    }

    public function getLinksSettings($locale = null)
    {
        $optionKey = sprintf(self::LINKS_SETTINGS_LOCALE_KEY, $locale);

        $settings = \Option::get($optionKey);

        return $settings;
    }
}