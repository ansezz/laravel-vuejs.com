<?php


namespace Next\Services;


use Next\Models\Attachment;
use Next\Models\Menu;
use Next\Themosis\Admin\Features\MultiLanguageFeature;
use Next\Transformers\AttachmentTransformer;
use Next\Transformers\MenuTransformer;
use Next\Transformers\PostTransformer;

class SettingService
{
    const GLOBAL_SETTINGS_KEY = 'global_settings';
    const GLOBAL_SETTINGS_LOCALE_KEY = 'global_settings_%s';

    const MENUS_SETTINGS_KEY = 'menus_settings';
    const MENUS_SETTINGS_LOCALE_KEY = 'menus_settings_%s';

    const LINKS_SETTINGS_KEY = 'links_settings';
    const LINKS_SETTINGS_LOCALE_KEY = 'links_settings_%s';

    const BREAKING_NEWS_SETTINGS_KEY = 'breaking_news_settings';
    const BREAKING_NEWS_SETTINGS_LOCALE_KEY = 'breaking_news_settings_%s';

    protected $postService;
    protected $postTransformer;

    public function __construct(PostService $postService, PostTransformer $postTransformer)
    {
        $this->postService = $postService;
        $this->postTransformer = $postTransformer;
    }

    private function getAttachment($attachmentId)
    {
        $attributes = [
            'post_title',
            'guid',
            'post_mime_type',
            'post_content',
            'post_excerpt'
        ];

        return Attachment::select($attributes)->find($attachmentId);
    }

    public function getGlobalSettings($locale = null)
    {
        $optionKey = MultiLanguageFeature::isEnabled() ?
            sprintf(self::GLOBAL_SETTINGS_LOCALE_KEY, $locale) :
            self::GLOBAL_SETTINGS_KEY;

        $settings = \Option::get($optionKey);

        if ($headerLogo = $this->getAttachment($settings['header_logo'])) {
            $settings['header_logo'] = AttachmentTransformer::item($headerLogo);
        }

        if ($footerLogo = $this->getAttachment($settings['footer_logo'])) {
            $settings['footer_logo'] = AttachmentTransformer::item($footerLogo);
        }

        return $settings;
    }

    public function getMenusSettings($locale = null)
    {
        $optionKey = MultiLanguageFeature::isEnabled() ?
            sprintf(self::MENUS_SETTINGS_LOCALE_KEY, $locale) :
            self::GLOBAL_SETTINGS_KEY;

        $settings = \Option::get($optionKey);

        if (is_array($settings)) {
            foreach ($settings as $key => $value) {
                $menu = Menu::slug($value)->first();
                $settings[$key] = MenuTransformer::item($menu);
            }
        }

        return $settings;
    }

    public function getLinksSettings($locale = null)
    {
        $optionKey = MultiLanguageFeature::isEnabled() ?
            sprintf(self::LINKS_SETTINGS_LOCALE_KEY, $locale) :
            self::GLOBAL_SETTINGS_KEY;

        $settings = \Option::get($optionKey);

        return $settings;
    }

    public function getBreakingNewsSettings($locale = null)
    {
        $optionKey = MultiLanguageFeature::isEnabled() ?
            sprintf(self::BREAKING_NEWS_SETTINGS_LOCALE_KEY, $locale) :
            self::BREAKING_NEWS_SETTINGS_KEY;

        $result = \Option::get($optionKey);

        $post = null;
        if ($result['selected_post']) {
            $post = $this->postService->getByIdOrSlug((int)$result['selected_post'], $locale);
            $post = $this->postTransformer->item($post);
        }

        return [
            'is_active' => isset($result['is_active']) ? $result['is_active'] : false,
            'post' => $post
        ];
    }
}