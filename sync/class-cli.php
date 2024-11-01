<?php

namespace TF\AccessPackage\Sync;

use WP_CLI;

class CLI
{
    /**
     * Sync jobs to WordPress
     *
     * @alias sync
     */
    public function sync($args)
    {
        $sync_result = Importer::instance()::import();

        if (! $sync_result) {
            WP_CLI::error('Error, no posts synced');
        }

        WP_CLI::success('Sync complete!');
    }
}

WP_CLI::add_command('car', '\TF\AccessPackage\Sync\CLI');
