<?php if (!defined('ABSPATH')) {
   exit;
}
?>

<div style="<?php echo esc_attr($hide_content); ?>">
    <h2><?php esc_html_e('DNB settings', 'access-package-integration'); ?></h2>

    <table class="form-table">
        <tr valign="top">
            <th scope="row"><?php esc_html_e('Activate DNB integration', 'access-package-integration'); ?></th>
            <td>
                <input
                    type="checkbox"
                    name="access_package_dnb_integration"
                    value="1"
                    <?php checked(get_option('access_package_dnb_integration'), "1"); ?>
                />
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php esc_html_e('DNB Dealer ID', 'access-package-integration'); ?></th>
            <td>
                <input
                    type="text"
                    name="access_package_dnb_dealer_id"
                    id="access_package_dnb_dealer_id"
                    placeholder="DNB Dealer ID"
                    value="<?php echo get_option('access_package_dnb_dealer_id'); ?>"
                />
            </td>
        </tr>

        <tr valign="top">
            <th scope="row">Knapptext för DNB</th>
            <td>
                <input
                    type="text"
                    name="access_package_dnb_button_text"
                    id="access_package_dnb_button_text"
                    placeholder="Köp online"
                    value="<?php echo get_option('access_package_dnb_button_text'); ?>"
                />
            </td>
        </tr>

    </table>
</div>
