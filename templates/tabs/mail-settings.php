<?php if (!defined('ABSPATH')) {
    exit;
}
?>

<div style="<?php echo esc_attr($hide_content); ?>">
    <h2><?php esc_html_e('Mail settings', 'access-package-integration'); ?></h2>

    <table class="form-table">
        <tr valign="top">
            <th scope="row"><?php esc_html_e('Scroll to content after car on click on "Mail"', 'access-package-integration'); ?></th>
            <td>
                <input type="checkbox" name="access_package_scroll_to_mail" value="1" <?php checked(get_option('access_package_scroll_to_mail'), "1"); ?> />
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><?php esc_html_e('Show form for "Intresseanmälan"', 'access-package-integration'); ?></th>
            <td>
                <input type="checkbox" name="access_package_enable_dealer_form" value="1" <?php checked(get_option('access_package_enable_dealer_form'), "1"); ?> />
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><?php esc_html_e('Thank you message after "Intresseanmälan" submit', 'access-package-integration'); ?></th>
            <td>
            <textarea style="width:400px; max-width: calc(100% - 10px);"
                name="access_package_interest_form_message"
                ><?php echo esc_attr(get_option('access_package_interest_form_message')); ?></textarea>
            </td>
        </tr>
    </table>
</div>
