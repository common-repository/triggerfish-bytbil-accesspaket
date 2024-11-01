<?php

namespace TF\AccessPackage;

use TF\AccessPackage\Sync;

class PostTypes
{
    public static function setupPostTypes()
    {
        $args = [
            'labels' => ['name' => 'Bil'],
            'public' => false,
            'publicly_queryable' => true,
            'show_ui' => false,
            'show_in_menu' => false,
            'rewrite' => ['slug' => 'bil'],
            'has_archive' => false,
            'supports' => ['title', 'editor'],
        ];

        register_post_type(
            Sync\Car::$postType,
            $args
        );
    }
}
