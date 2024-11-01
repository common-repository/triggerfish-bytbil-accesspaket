<?php

namespace TF\AccessPackage;

use TF\AccessPackage\Sync;

class Plugin
{
    public static $instance;

    private function __construct()
    {
        include_once TFAP_PLUGIN_DIR . '/sync/class-importer.php';
        include_once TFAP_PLUGIN_DIR . '/sync/class-car.php';
        include_once TFAP_PLUGIN_DIR . '/classes/class-api.php';
        include_once TFAP_PLUGIN_DIR . '/classes/class-post-types.php';
        include_once TFAP_PLUGIN_DIR . '/classes/class-rest-routes.php';
        include_once TFAP_PLUGIN_DIR . '/classes/class-settings.php';
        include_once TFAP_PLUGIN_DIR . '/classes/class-scripts.php';
        include_once TFAP_PLUGIN_DIR . '/classes/class-shortcode.php';
        include_once TFAP_PLUGIN_DIR . '/classes/class-car.php';
        include_once TFAP_PLUGIN_DIR . '/classes/class-metabox.php';
        include_once TFAP_PLUGIN_DIR . '/classes/class-ajax.php';
        include_once TFAP_PLUGIN_DIR . '/filter-fields/class-brand.php';
        include_once TFAP_PLUGIN_DIR . '/filter-fields/class-mileage.php';
        include_once TFAP_PLUGIN_DIR . '/filter-fields/class-price.php';
        include_once TFAP_PLUGIN_DIR . '/filter-fields/class-type.php';
        include_once TFAP_PLUGIN_DIR . '/filter-fields/class-used.php';
        include_once TFAP_PLUGIN_DIR . '/filter-fields/class-year.php';
        include_once TFAP_PLUGIN_DIR . '/filter-fields/class-gearbox.php';
        include_once TFAP_PLUGIN_DIR . '/filter-fields/class-color.php';
        include_once TFAP_PLUGIN_DIR . '/filter-fields/class-fuel.php';
        include_once TFAP_PLUGIN_DIR . '/filter-fields/class-fourwheeldrive.php';
        include_once TFAP_PLUGIN_DIR . '/filter-fields/class-has-image.php';
        include_once TFAP_PLUGIN_DIR . '/filter-fields/class-leasing.php';
        include_once TFAP_PLUGIN_DIR . '/filter-fields/class-city.php';
        include_once TFAP_PLUGIN_DIR . '/filter-fields/class-beds.php';
        include_once TFAP_PLUGIN_DIR . '/filter-fields/class-length.php';
        include_once TFAP_PLUGIN_DIR . '/filter-fields/class-towbar.php';
        include_once TFAP_PLUGIN_DIR . '/filter-fields/class-model.php';
        include_once TFAP_PLUGIN_DIR . '/filter-fields/class-dealer.php';
        include_once TFAP_PLUGIN_DIR . '/admin/class-ajax-handler.php';
        include_once TFAP_PLUGIN_DIR . '/car/car-filters.php';

        if (class_exists('WP_CLI')) {
            include_once TFAP_PLUGIN_DIR . '/sync/class-cli.php';
        }

        $this->addActions();
        $this->addFilters();
        $this->loadTranslations();

        register_activation_hook(TFAP_PLUGIN_FILE, [__CLASS__, 'onActivation']);
        register_deactivation_hook(TFAP_PLUGIN_FILE, [__CLASS__, 'onDeactivation']);

        new Ajax();
    }

    private function addActions()
    {
        add_action('init', [PostTypes::class, 'setupPostTypes']);
        add_action('init', [Scripts::class, 'loadScripts']);
        add_action('init', [Shortcode::class, 'addShortcode']);
        add_action('init', [Sync\Scheduler::class, 'addCronEvent']);
        add_action('init', [Sync\Scheduler::class, 'scheduleEvent']);
        add_action('rest_api_init', [RestRoutes::class, 'register']);
        add_action('admin_menu', [Settings::class, 'addMenuPage']);
        add_action('admin_init', [Settings::class, 'registerSettings']);
        add_action('add_meta_boxes', [Metabox::class, 'registerMetaboxes']);
        add_action('admin_enqueue_scripts', [Metabox::class, 'enqueueAdminAssets']);
        add_action('save_post', [Metabox::class, 'saveMetaBoxes']);
    }

    private function addFilters()
    {
        add_filter('template_include', [CarFilters::class, 'templateInclude']);
        add_filter('theme_page_templates', [CarFilters::class, 'registerPageTemplate']);
    }

    private function loadTranslations()
    {
        add_action('init', function () {
            load_plugin_textdomain('access-package-integration', false, basename(TFAP_PLUGIN_DIR) . '/languages');
        });
        load_muplugin_textdomain('access-package-integration', basename(TFAP_PLUGIN_DIR) . '/languages');
    }

    public static function onActivation()
    {
        Sync\Scheduler::scheduleEvent();
        flush_rewrite_rules();
    }

    public static function onDeactivation()
    {
        Sync\Scheduler::clearScheduledHook();
    }

    public static function instance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
