<?php

/**
 * Plugin name: Bytbil Accesspaket
 * Author: Triggerfish AB
 * Author URI: https://www.triggerfish.se
 * Text Domain: access-package-integration
 * Version: 2.3.12
 * Description: Plugin för att visa bilar till salu.
 */

namespace TF\AccessPackage;

use TF\AccessPackage\sync\Importer;

if (!defined('ABSPATH')) {
    exit;
}

define('TFAP_PLUGIN_VERSION', 2.3);

define('TFAP_PLUGIN_DIR', __DIR__);
define('TFAP_PLUGIN_URL', plugin_dir_url(__FILE__));
define('TFAP_PLUGIN_FILE', __FILE__);
define('TFAP_REACT_PATH', TFAP_PLUGIN_DIR . '/frontend');
define('TFAP_ASSET_MANIFEST', TFAP_REACT_PATH . '/build/asset-manifest.json');
define('TFAP_CLASSES', TFAP_PLUGIN_DIR . '/classes');
define('TFAP_ASSETS', plugins_url('assets', __FILE__));

require_once(TFAP_PLUGIN_DIR . '/classes/class-plugin.php');
require_once(TFAP_PLUGIN_DIR . '/sync/class-scheduler.php');

register_activation_hook(TFAP_PLUGIN_FILE, [Plugin::class, 'onActivation']);
register_deactivation_hook(TFAP_PLUGIN_FILE, [Plugin::class, 'onDeactivation']);

add_action('plugins_loaded', function () {
    Plugin::instance();
});

if (!is_network_admin()) {
    add_action('admin_init', function () {
        if (isset($_GET['action']) && 'manual-car-sync' === $_GET['action']) {
            Importer::instance()::import(true);
            echo '<div class="notice notice-success is-dismissible"><p>Alla bilar är nu synkade.</p></div>';
        }
    }, 99);

    add_action('admin_bar_menu', function ($admin_bar) {
        $admin_bar->add_menu([
            'id'    => 'manual-wp-car-sync',
            'title' => esc_attr__('Sync cars', 'wptemplate'),
            'href'  => admin_url('?action=manual-car-sync'),
            'meta'  => [
                'title' => esc_attr__('Sync cars', 'wptemplate'),
            ],
        ]);
    }, 98);
}
