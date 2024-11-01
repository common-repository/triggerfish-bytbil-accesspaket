<?php

if (!defined('ABSPATH')) {
    exit;
}
?>

<div style="<?php echo esc_attr($hide_content); ?>">
    <h2><?php esc_html_e('Content to show on single car page', 'access-package-integration'); ?></h2>

    <table class="form-table description-table">
        <tr valign="top" class="description-item">
            <td>
                <textarea
                    name="access_package_single_car_content"
                    id="access_package_single_car_content"
                    rows="12"
                    class="js-access-package-single-car-content"
                    style="width: 100%;"
                >
                    <?php echo get_option('access_package_single_car_content'); ?>
                </textarea>
            </td>
        </tr>
    </table>
    <h2><?php esc_html_e('Custom finanace settings', 'access-package-integration'); ?></h2>
    <table class="form-table finance-settings-table">
        <tr valign="top">
            <th scope="row"><?php echo esc_html__('Background color', 'access-package-integration'); ?></th>
            <td>
                <input 
                    type="text"
                    class="tfap-color-field"
                    name="access_package_finance_bg_color"
                    value="<?php echo get_option('access_package_finance_bg_color') ?? null; ?>"
                 />
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php echo esc_html__('Text color', 'access-package-integration'); ?></th>
            <td>
                <input
                    type="text"
                    class="tfap-color-field"
                    name="access_package_finance_text_color"
                    value="<?php echo get_option('access_package_finance_text_color') ?? null; ?>" 
                />
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php echo esc_html__('Hide price per month', 'access-package-integration'); ?></th>
            <td>
                <input
                    type="checkbox"
                    name="access_package_finance_hide_monthly_price"
                    value="1"
                    <?php checked(get_option('access_package_finance_hide_monthly_price'), "1"); ?>
                />
            </td>
        </tr>
    </table>
</div>