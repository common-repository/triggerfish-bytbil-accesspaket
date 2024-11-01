<?php

namespace TF\AccessPackage;

use TF\AccessPackage\Admin\AjaxHandler;

include_once TFAP_CLASSES . '/class-descriptions.php';
include_once TFAP_CLASSES . '/class-hero.php';
include_once TFAP_CLASSES . '/class-filters.php';

class RestRoutes
{
    private static $namespace = 'accesspackage/v1';
    private static $carsRoute = 'cars';
    private static $filtersRoute = 'filters';
    private static $sortRoute = 'saveFilterOrder';
    private static $heroRoute = 'saveHeroImage';
    private static $fallbackRoute = 'saveFallbackImage';
    private static $mailRoute = 'mail';

    public static function register()
    {
        register_rest_route(self::$namespace, self::$carsRoute, [
            'methods' => 'GET',
            'callback' => [Car::class, 'all'],
        ]);

        register_rest_route(self::$namespace, self::$filtersRoute, [
            'methods' => 'GET',
            'callback' => [Filters::class, 'active'],
        ]);

        register_rest_route(self::$namespace, self::$filtersRoute, [
            'methods' => 'GET',
            'callback' => [Filters::class, 'active'],
            'args' => [
                'post_id',
            ],
        ]);

        register_rest_route(self::$namespace, self::$mailRoute, [
            'methods' => 'GET',
            'callback' => [Mailer::class, 'mail'],
            'args' => [
                'contact',
                'message',
                'url',
            ],
        ]);

        register_rest_route(self::$namespace, self::$sortRoute, [
            'methods' => 'POST',
            'callback' => [AjaxHandler::class, 'saveFilterOrder'],
        ]);

        register_rest_route(self::$namespace, self::$heroRoute, [
            'methods' => 'POST',
            'callback' => [AjaxHandler::class, 'saveHeroImage'],
        ]);

        register_rest_route(self::$namespace, self::$fallbackRoute, [
            'methods' => 'POST',
            'callback' => [AjaxHandler::class, 'saveFallbackImage'],
        ]);
    }
}
