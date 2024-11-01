<?php

if (!defined('ABSPATH')) {
    exit;
}
?>

<div style="<?php echo esc_attr($hide_content); ?>">
    <h2><?php esc_html_e('Theming settings', 'access-package-integration'); ?></h2>

    <table class="form-table">
        <?php
            include TFAP_PLUGIN_DIR . '/templates/tabs/theming-settings-fields.php';
        ?>

        <tr valign="top">
            <th scope="row"><?php echo esc_html__('Hero background image', 'access-package-integration'); ?></th>
            <td>
                <?php $image_id = get_option('access_package_hero_background_image'); ?>
                <div style="display: flex; flex-direction: column;">
                    <div>
                        <input
                            type="hidden"
                            class="tfap-hero-background-image-field"
                            name="access_package_hero_background_image"
                            value="<?php echo esc_attr($image_id); ?>" />
                        <input
                            type="button"
                            class="button-primary"
                            value="<?php esc_attr_e('Select an image', 'access-package-integration'); ?>"
                            id="access_package_hero_background_image_manager"
                            style="margin-bottom: 20px;" />
                    </div>

                    <div class="js-tfap-image-container" style="display: flex; max-width:300px; flex-direction: column;">
                        <?php
                        if (intval($image_id) > 0) {
                            echo wp_get_attachment_image(
                                $image_id,
                                'medium',
                                false,
                                ['id' => 'access-package-hero-background-image-preview']
                            );
                            echo sprintf(
                                '<span class="plugins trash"><a href="#" class="%s">%s</a></span>',
                                'js-tfap-remove-img delete',
                                esc_html__('Remove image', 'access-package-imtegration')
                            );
                        }
                        ?>
                    </div>
                </div>


            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php echo esc_html__('Custom fallback image', 'access-package-integration'); ?></th>
            <td>
                <?php $fallback_image_id = get_option('access_package_custom_fallback_image'); ?>
                <div style="display: flex; flex-direction: column;">
                    <div>
                        <input
                            type="hidden"
                            class="tfap-custom-fallback-image-field"
                            name="access_package_custom_fallback_image"
                            value="<?php echo esc_attr($fallback_image_id); ?>" />
                        <input
                            type="button"
                            class="button-primary"
                            value="<?php esc_attr_e('Select an image', 'access-package-integration'); ?>"
                            id="access_package_custom_fallback_image_manager"
                            style="margin-bottom: 20px;" />
                    </div>
                    <div class="js-tfap-fallback-image-container" style="display: flex; max-width:300px; flex-direction: column;">
                        <?php
                        if (intval($fallback_image_id) > 0) {
                            echo wp_get_attachment_image(
                                $fallback_image_id,
                                'medium',
                                false,
                                ['id' => 'access-package-custom-fallback-image-preview']
                            );
                            echo sprintf(
                                '<span class="plugins trash"><a href="#" class="%s">%s</a></span>',
                                'js-tfap-remove-fallback-img delete',
                                esc_html__('Remove image', 'access-package-imtegration')
                            );
                        }
                        ?>
                    </div>
                </div>
            </td>
            <tr valign="top">
                <th scope="row"><?php echo esc_html__('Visa bilar exklusive moms', 'access-package-integration'); ?></th>
                <td>
                    <input
                        type="checkbox"
                        name="access_package_ex_vat_price"
                        value="1"
                        <?php checked(get_option('access_package_ex_vat_price'), "1"); ?>
                    />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php echo esc_html__('Use tight layout for search field and filters', 'access-package-integration'); ?></th>
                <td>
                    <input
                        type="checkbox"
                        name="access_package_tight_layout"
                        value="1"
                        <?php checked(get_option('access_package_tight_layout'), "1"); ?>
                    />
                </td>
            </tr>
        </tr>
    </table>
</div>
