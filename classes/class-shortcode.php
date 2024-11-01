<?php

namespace TF\AccessPackage;

class Shortcode
{
    public static function addShortcode()
    {
        add_shortcode('tfap_widget', function () {
            ob_start();
            include_once TFAP_PLUGIN_DIR . '/templates/shortcode.php';
            return ob_get_clean();
        });
    }
}
