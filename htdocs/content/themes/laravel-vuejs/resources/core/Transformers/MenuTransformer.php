<?php


namespace Core\Transformers;


use Core\Models\Menu;
use Core\Models\MenuItem;

class MenuTransformer
{

    public static function item(Menu $menu)
    {
        $items = self::menuItems($menu);

        return [
            'id' => $menu->getKey(),
            'name' => $menu->term()->first()->name,
            'slug' => $menu->term()->first()->slug,
            'items' => $items
        ];
    }

    private static function menuItems(Menu $menu)
    {
        $menuItems = wp_get_nav_menu_items($menu->getKey());

        return array_map(function ($item) {
            return [
                'name' => $item->title,
                'fullUrl' => $item->url,
                'path' => strtolower(preg_replace('#^https?://#', '', $item->url)),
                'object' => $item->object,
            ];
        }, $menuItems);
    }

    /**
     * @deprecated
     *
     * @param MenuItem $menuItem
     * @return array
     *
     */
    private static function menuItem(MenuItem $menuItem)
    {
        return [
            'items' => wp_get_nav_menu_items($menuItem->getSlug()),
            'instance' => $menuItem->instance(),
            'type' => $menuItem->getPostType(),
            'name' => $menuItem->instance()
        ];
    }

}