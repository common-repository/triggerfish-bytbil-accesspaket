<?php

namespace TF\AccessPackage;

class CarFilters
{
    private static $templateName = 'template-car-archive.php';

    public static function templateInclude($template)
    {
        if (is_singular(Sync\Car::$postType)) {
            return TFAP_PLUGIN_DIR . '/templates/single-car.php';
        }

        if (get_page_template_slug() === self::$templateName) {
            return sprintf('%s/templates/%s', TFAP_PLUGIN_DIR, self::$templateName);
        }

        return $template;
    }

    public static function registerPageTemplate($post_templates)
    {
        $post_templates[self::$templateName] = __('Car archive', 'access-package-integration');

        return $post_templates;
    }
}
