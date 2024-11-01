<?php

namespace TF\AccessPackage\Sync;

class Scheduler
{
    private const CRON_ACTION = 'access-package/car-sync';

    public static function addCronEvent()
    {
        add_action(self::CRON_ACTION, function () {
            Importer::instance()::import();
        });

        add_filter('cron_schedules', [__CLASS__, 'setCronSchedules']);
    }

    public static function scheduleEvent()
    {
        add_filter('cron_schedules', __NAMESPACE__ . '\Scheduler::setCronSchedules');
        if (!wp_next_scheduled(self::CRON_ACTION)) {
            wp_schedule_event(time(), 'every_five_minutes', self::CRON_ACTION);
        }
    }

    public static function setCronSchedules($schedules)
    {
        $schedules['every_five_minutes'] = [
            'interval' => MINUTE_IN_SECONDS * 5,
            'display' => __('Every five minutes', 'poolia-intelliplan'),
        ];

        return $schedules;
    }

    public static function clearScheduledHook()
    {
        \wp_clear_scheduled_hook(self::CRON_ACTION);
    }
}
