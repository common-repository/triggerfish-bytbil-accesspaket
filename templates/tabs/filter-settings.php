<?php

if (!defined('ABSPATH')) {
    exit;
}
$MAX_FILTER_DESKTOP = !empty(get_option('access_package_filters_max_displayed_desktop')) ? get_option('access_package_filters_max_displayed_desktop') : 12;
$MAX_FILTER_MOBILE = !empty(get_option('access_package_filters_max_displayed_mobile')) ? get_option('access_package_filters_max_displayed_mobile') : 4;
?>

<div style="<?php echo esc_attr($hide_content); ?>">
    <h2><?php esc_html_e('Filters to show', 'access-package-integration'); ?></h2>
    <p>
        <strong>Desktop:</strong>
        <br>
        <span>
            <?php
            echo sprintf('De %s första valda filterna kommer alltid vara synliga.', $MAX_FILTER_DESKTOP);
            ?>
        </span>
        <br>
        <span>Resterande valda filter kommer läggas under "Fler filter"</span>
    </p>
    <p>
        <strong>Mobil:</strong>
        <br>
        <span>
            <?php
            echo sprintf('De %s första valda filterna kommer alltid vara synliga.', $MAX_FILTER_MOBILE);
            ?>
        </span>
        <br>
        <span>Resterande valda filter kommer läggas under "Fler filter"</span>
    </p>
    <p style="margin-bottom: 0; font-size: 0.9em; "><i>Du kan ändra dessa inställningar längst ned på denna sida</i></p>
    <hr>
    <h4>
        <?php
        esc_html_e(
            'You can drag and drop the filters to get the order that you want.',
            'access-package-integration'
        );
        ?>
    </h4>
    <table class="form-table filter-table" style="width: auto;">
        <thead style="border-bottom: 1px solid #ccc">
            <tr>
                <th><?php _e('Name', 'access-package-integration'); ?></th>
                <th style="text-align: center;"><?php _e('Show filter?', 'access-package-integration'); ?></th>
                <th style="text-align: center;"><?php _e('Position', 'access-package-integration'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (\TF\AccessPackage\Filters::sortedFilters() as $filter_field) : ?>
                <tr valign="top" class="filter-item" style="border-bottom: 1px solid #ccc;">
                    <th scope="row"><?php echo esc_html($filter_field['label']); ?></th>
                    <td style="text-align: center;">
                        <input type="checkbox" name="<?php echo esc_attr($filter_field['field']); ?>" value="1" <?php echo checked(get_option($filter_field['field'])); ?> />
                    </td>
                    <td style="cursor:grab; text-align:center;" class="js-handle-drag">
                        <span><span class="dashicons dashicons-move"></span></span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <table class="form-table filter-table" style="width: auto;">
        <tbody>
            <tr valign="top">
                <th scope="row"><?php echo esc_html__('Max visible filters in mobile', 'access-package-integration'); ?></th>
                <td>
                    <input type="number" name="access_package_filters_max_displayed_mobile" value="<?php echo $MAX_FILTER_MOBILE; ?>" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php echo esc_html__('Max visible filters in desktop', 'access-package-integration'); ?></th>
                <td>
                    <input type="number" name="access_package_filters_max_displayed_desktop" value="<?php echo $MAX_FILTER_DESKTOP; ?>" />
                </td>
            </tr>
        </tbody>
    </table>
</div>