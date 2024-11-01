<?php

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap">
    <h1><?php esc_html_e('BytBil access package', 'access-package-integration'); ?></h1>

    <h2><?php esc_html_e('API settings', 'access-package-integration'); ?></h2>

    <?php
    $tabs = [
        'general' => esc_html__('General', 'access-package-integration'),
        'filter' => esc_html__('Filters', 'access-package-integration'),
        'theming' => esc_html__('Theming', 'access-package-integration'),
        'description' => esc_html__('Description', 'access-package-integration'),
        'mail' => esc_html__('Mail', 'access-package-integration'),
        'dnb' => esc_html__('DNB', 'access-package-integration'),
    ];

    if (!apply_filters('access_package_hide_single_car_content', false)) {
      $tabs['single-car'] = esc_html__('Single car view', 'access-package-integration');
    }

    $current = !empty($_GET['tab']) ? esc_attr($_GET['tab']) : 'general';
    ?>

    <form method="post" action="options.php">
        <?php settings_fields(\TF\AccessPackage\Settings::$settingsGroup); ?>
        <?php do_settings_sections(\TF\AccessPackage\Settings::$settingsGroup); ?>
        <h2 class="nav-tab-wrapper">
            <?php foreach ($tabs as $tab => $name) : ?>
                <?php $class = ($tab == $current) ? ' nav-tab-active' : ''; ?>
                <a
                    href="?page=access-package.php&tab=<?php echo esc_attr($tab); ?>"
                    class="nav-tab<?php echo esc_attr($class); ?>"
                >
                    <?php echo $name; ?>
                </a>
            <?php endforeach; ?>
        </h2>

        <?php
        foreach ($tabs as $tab => $name) {
            $hide_content = ($tab !== $current) ? 'display: none;' : '';
            include_once 'tabs/' . $tab . '-settings.php';
        }
        ?>

        <?php submit_button(); ?>
    </form>
</div>
