<?php

if (!defined('ABSPATH')) {
    exit;
}
?>

<div style="<?php echo esc_attr($hide_content); ?>">
    <h2><?php esc_html_e('General settings', 'access-package-integration'); ?></h2>
    <table class="form-table">
        <tr valign="top">
            <th scope="row"><?php esc_html_e('JSON file', 'access-package-integration'); ?></th>
            <td>
                <input
                    type="text"
                    name="access_package_json_file"
                    value="<?php echo esc_attr(get_option('access_package_json_file')); ?>"
                />
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><?php esc_html_e('Token', 'access-package-integration'); ?></th>
            <td>
                <input
                    type="text"
                    name="access_package_token"
                    value="<?php echo esc_attr(get_option('access_package_token')); ?>"
                />
            </td>
        </tr>
    </table>
</div>
