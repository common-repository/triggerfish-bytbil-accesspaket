<?php

namespace TF\AccessPackage\Sync;

use TF\AccessPackage\API;

class Importer
{
    public static $instance;
    private static $feed = null;

    public static function import($alwaysUpdate = false)
    {
        $api = new API();
        self::$feed = $api->getFeed();

        if (self::$feed === false) {
            return false;
        }
        self::syncPosts($alwaysUpdate);

        return 5;
    }

    private static function syncPosts($alwaysUpdate = false)
    {
        $postIds = [];
        array_map(function ($car) use (&$postIds, $alwaysUpdate) {
            $car = new Car($car);
            $car->syncCarToPost($alwaysUpdate);
            $postIds[] = $car->postId;
        }, self::$feed);

        $postsToDelete = new \WP_Query([
            'post_type' => Car::$postType,
            'numberposts' => 999,
            'posts_per_page' => 999,
            'post__not_in' => $postIds,
            'fields' => 'ids',
        ]);

        foreach ($postsToDelete->posts as $deletePost) {
            \wp_delete_post($deletePost, true);
        }
    }

    public static function instance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
