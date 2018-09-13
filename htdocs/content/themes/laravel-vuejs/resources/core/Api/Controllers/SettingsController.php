<?php

namespace Core\API\Controllers;

use Core\API\Services\SettingService;


/**
 * Class PostController
 * @package Core\Controllers\Api
 */
class SettingsController extends BaseController
{

    public function index(SettingService $settingService)
    {
        $global = $settingService->getGlobalSettings($this->locale);

        return $this->response->withArray([
            'global' => $global,
            'menus' => $settingService->getMenusSettings($this->locale),
            'links' => $settingService->getLinksSettings($this->locale)
        ]);

    }
}