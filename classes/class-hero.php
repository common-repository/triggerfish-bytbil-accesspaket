<?php

namespace TF\AccessPackage;

class Hero
{

    public static function fields()
    {
        return [
            'access_package_hero_image' => ['label' => esc_html__('Hero image', 'access-package-integration')],
        ];
    }
}
