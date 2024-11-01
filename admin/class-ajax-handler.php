<?php

namespace TF\AccessPackage\Admin;

class AjaxHandler
{
    public static function saveFilterOrder()
    {
        $data = $_POST['data'];

        if (!empty($data)) {
            update_option('tfap_filter_order', $data);
        }

        wp_send_json_success();
    }

    public static function saveHeroImage()
    {
        if (isset($_POST['id'])) {
            $image = wp_get_attachment_image(
                absint($_POST['id']),
                'medium',
                false,
                ['id' => 'access-package-hero-background-image-preview']
            );
            update_option('access_package_hero_background_image', absint($_POST['id']));
            wp_send_json_success(['image' => $image]);
        } else {
            wp_send_json_error();
        }
    }

    public static function saveFallbackImage()
    {
        if (isset($_POST['id'])) {
            $image = wp_get_attachment_image(
                absint($_POST['id']),
                'medium',
                false,
                ['id' => 'access-package-custom-fallback-image-preview']
            );
            update_option('access_package_custom_fallback_image', absint($_POST['id']));
            wp_send_json_success(['image' => $image]);
        } else {
            wp_send_json_error();
        }
    }
}
