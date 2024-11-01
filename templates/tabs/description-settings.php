<?php

if (!defined('ABSPATH')) {
    exit;
}
?>

<div style="<?php echo esc_attr($hide_content); ?>">
    <h2><?php esc_html_e('Descriptions to show', 'access-package-integration'); ?></h2>
    <p><?php esc_html_e('The checked descriptions will be shown in each of the car cards displayed in the archive feed.', 'access-package-integration'); ?></p>

    <table class="form-table description-table">
        <?php foreach (\TF\AccessPackage\Descriptions::getDescriptions() as $description) : ?>
            <tr valign="top" class="description-item">
                <th scope="row">
                    <label for="<?php echo strtolower($description['label']); ?>">
                        <?php echo $description['label']; ?>
                    </label>
                </th>
                <td>
                    <input id="<?php echo strtolower($description['label']); ?>" type="checkbox" name="<?php echo esc_attr($description['field']); ?>" value="1" <?php echo checked(get_option($description['field'], $description['default'])); ?> />
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
