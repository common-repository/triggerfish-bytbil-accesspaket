<?php

namespace TF\AccessPackage;

class Settings
{
    public static $settingsGroup = 'access-package-settings';

    public static function registerSettings()
    {
        register_setting(self::$settingsGroup, 'access_package_token');
        register_setting(self::$settingsGroup, 'access_package_json_file');
        register_setting(self::$settingsGroup, 'access_package_primary_color');
        register_setting(self::$settingsGroup, 'access_package_alt_color');
        register_setting(self::$settingsGroup, 'access_package_text_color');
        register_setting(self::$settingsGroup, 'access_package_font_family');
        register_setting(self::$settingsGroup, 'access_package_custom_heading');
        register_setting(self::$settingsGroup, 'access_package_custom_heading_size');
        register_setting(self::$settingsGroup, 'access_package_single_car_content');
        register_setting(self::$settingsGroup, 'access_package_scroll_to_mail');
        register_setting(self::$settingsGroup, 'access_package_enable_dealer_form');
        register_setting(self::$settingsGroup, 'access_package_dnb_integration');
        register_setting(self::$settingsGroup, 'access_package_dnb_dealer_id');
        register_setting(self::$settingsGroup, 'access_package_dnb_button_text');
        register_setting(self::$settingsGroup, 'access_package_finance_bg_color');
        register_setting(self::$settingsGroup, 'access_package_finance_text_color');
        register_setting(self::$settingsGroup, 'access_package_interest_form_message');
        register_setting(self::$settingsGroup, 'access_package_finance_hide_monthly_price');
        register_setting(self::$settingsGroup, 'access_package_ex_vat_price');
        register_setting(self::$settingsGroup, 'access_package_filters_max_displayed_desktop');
        register_setting(self::$settingsGroup, 'access_package_filters_max_displayed_mobile');
        register_setting(self::$settingsGroup, 'access_package_tight_layout');

        $filters = new Filters();
        $descriptions = new Descriptions();
        $hero = new Hero();

        self::registerFilterSettings($filters->fields());
        self::registerFilterSettings($filters->fieldsShowMore());
        self::registerFilterSettings($descriptions->fields());
        self::registerFilterSettings($hero->fields());
    }

    private static function registerFilterSettings(array $settings)
    {
        if (empty($settings)) {
            return;
        }

        foreach ($settings as $key => $field) {
            register_setting(self::$settingsGroup, $key);
        }
    }

    public static function addMenuPage()
    {
        add_options_page(
            esc_html__('Access package', 'access-package-integration'),
            esc_html__('Access package', 'access-package-integration'),
            'manage_options',
            'access-package.php',
            [__CLASS__, 'renderOptionsPage']
        );
    }

    public static function renderOptionsPage()
    {
        include_once TFAP_PLUGIN_DIR . '/templates/options-page.php';
    }
}
