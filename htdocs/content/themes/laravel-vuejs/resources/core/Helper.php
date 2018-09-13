<?php


namespace Core;


class Helper
{
    public static function staticUrl($url)
    {
        return str_replace(WP_HOME, WP_CONTENT_URL, $url);
    }
}