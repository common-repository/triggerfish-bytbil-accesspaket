<?php $show_theming_settings = apply_filters('access_package_show_theming_settings', true); ?>

<?php if ($show_theming_settings) : ?>
    <tr valign="top">
        <th scope="row"><?php echo esc_html__('Primary color', 'access-package-integration'); ?></th>
        <td>
            <input type="text" class="tfap-color-field" name="access_package_primary_color" value="<?php echo esc_attr(get_option('access_package_primary_color')); ?>" />
        </td>
    </tr>
<?php endif; ?>

<tr valign="top">
    <th scope="row"><?php echo esc_html__('Alternative color', 'access-package-integration'); ?></th>
    <td>
        <input type="text" class="tfap-color-field" name="access_package_alt_color" value="<?php echo !empty(get_option('access_package_alt_color')) ? esc_attr(get_option('access_package_alt_color')) : esc_attr(get_option('access_package_primary_color')); ?>" />
    </td>
</tr>

<?php if ($show_theming_settings) : ?>
    <tr valign="top">
        <th scope="row"><?php echo esc_html__('Text color', 'access-package-integration'); ?></th>
        <td>
            <input type="text" class="tfap-text-color-field" name="access_package_text_color" value="<?php echo esc_attr(get_option('access_package_text_color')); ?>" />
        </td>
    </tr>


    <tr valign="top">
        <th scope="row"><?php echo esc_html__('Font family', 'access-package-integration'); ?></th>
        <td>
            <?php
            $tfap_google_fonts = [
                'Lato',
                'Montserrat',
                'Open Sans',
                'Oswald',
                'PT Sans',
                'Raleway',
                'Roboto Condensed',
                'Roboto',
                'Slabo 27px',
                'Source Sans Pro',
            ];
            $selected_font = get_option('access_package_font_family');
            ?>
            <select class="tfap-font-family-field" name="access_package_font_family">
                <option value="inherit" <?php !empty($options['select_field_0']) ? selected($options['select_field_0'], 1) : ''; ?>>
                    <?php esc_html_e('Use your own theme fonts', 'access-package-integration'); ?>
                </option>
                <?php foreach ($tfap_google_fonts as $font) : ?>
                    <option value="<?php echo $font; ?>" <?php echo $selected_font === $font ? 'selected' : ''; ?>>
                        <?php echo $font; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </td>
    </tr>
<?php endif; ?>

<tr valign="top">
    <th scope="row"><?php esc_html_e('Custom Heading', 'access-package-integration'); ?></th>
    <td>
        <input type="text" name="access_package_custom_heading" value="<?php echo esc_attr(get_option('access_package_custom_heading')); ?>" />
    </td>
</tr>

<tr valign="top">
    <th scope="row"><?php esc_html_e('Custom Heading Size', 'access-package-integration'); ?></th>
    <td>
        <?php
        $tfap_heading_sizes = [
            'H1',
            'H2',
            'H3',
        ];
        $selected_size = get_option('access_package_custom_heading_size');
        ?>
        <select name="access_package_custom_heading_size">
            <?php foreach ($tfap_heading_sizes as $size) : ?>
                <option value="<?php echo $size; ?>" <?php echo $selected_size === $size ? 'selected' : ''; ?>>
                    <?php echo $size; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </td>
</tr>