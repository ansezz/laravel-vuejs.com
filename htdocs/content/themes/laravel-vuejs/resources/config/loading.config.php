<?php

return [

    /*
    * Edit this file in order to configure your theme's
    * classes autoloading. Classes are loaded using PSR-4.
    *
    * The key is the namespace and key's value contains one or more paths to your classes.
    */
    'Theme\\Controllers\\' => themosis_path('theme.resources') . 'controllers',
    'Theme\\Models\\' => themosis_path('theme.resources') . 'models',
    'Theme\\Admin\\' => themosis_path('theme.resources') . 'admin',
    'Theme\\Providers\\' => themosis_path('theme.resources') . 'providers',

    'Core\\' => themosis_path('theme.resources') . 'core',
    'Core\\Controllers\\API\\' => themosis_path('theme.resources') . 'core' . DS . 'Api' . DS . 'Controllers',
    'Core\\Exceptions\\' => themosis_path('theme.resources') . 'core' . DS . 'Exceptions',
    'Core\\Models\\' => themosis_path('theme.resources') . 'core' . DS . 'Models',
    'Core\\Providers\\' => themosis_path('theme.resources') . 'core' . DS . 'Providers',
    'Core\\Repository\\' => themosis_path('theme.resources') . 'core' . DS . 'repository',
    'Core\\Services\\' => themosis_path('theme.resources') . 'core' . DS . 'Services',
    'Core\\Transformers\\' => themosis_path('theme.resources') . 'core' . DS . 'Transformers',
];
