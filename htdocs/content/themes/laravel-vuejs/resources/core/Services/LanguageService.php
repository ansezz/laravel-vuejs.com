<?php

namespace Core\Services;


use Illuminate\Http\Request;
use Themosis\Facades\Config;

class LanguageService
{
    protected $request;

    private $uri;

    public $locale;

    public function __construct()
    {
        $this->request = Request::createFromGlobals();
        $this->uri = $this->request->server->get('REQUEST_URI');
        $this->setup();
    }

    public function setup()
    {
        $this->setLocale();
        $this->defineWpConstants();
        $this->request->setLocale($this->locale);
    }

    private function setLocale()
    {
        $segment = explode('/', $this->uri);
        if (count($segment) > 0) {
            if ($segment[0] === 'api') {
                $localeIndex = 1;
            } elseif (in_array($segment[0], ['fr', 'ar'])) {
                $localeIndex = 0;
            } else {
                $localIndex = false;
            }

            if ($localIndex === false) {
                $this->locale = 'fr';
            } else {
                $this->locale = $segment[$localeIndex];
            }
        }
    }

    /**
     * For supporting native wp translations
     */
    private function defineWpConstants()
    {
        switch ($this->locale) {
            case 'fr':
                defined('LANG') ? LANG : define('LANG', 'fr_FR');
                break;
            case 'ar':
                defined('LANG') ? LANG : define('LANG', 'ar_MA');
                break;
        }
    }

    public function getRequest()
    {
        return $this->request;
    }

}