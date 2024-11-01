<?php

if (!defined('ABSPATH')) {
    exit;
}
?>

<h2 class="tfap-mt3 tfap-h3 tfap-mb1 tfap-color-black">
    <?php _e('Model information', 'access-package-integration'); ?>
</h2>

<?php if (!empty($data['regNo']) && !!empty($data['regNoHidden'])) : ?>
    <p class="tfap-model-info-row">
        <span><?php _e('Reg.nr', 'access-package-integration'); ?></span>
        <strong class="js-reg-no"><?php echo $data['regNo']; ?></strong>
    </p>
<?php endif; ?>

<?php if (!empty($data['milage'])) : ?>
    <p class="tfap-model-info-row">
        <span><?php _e('Milage', 'access-package-integration'); ?></span>
        <strong><?php echo number_format($data['milage'], 0, ' ', ' '); ?> mil</strong>
    </p>
<?php endif; ?>

<?php if (!empty($data['bodyType'])) : ?>
    <p class="tfap-model-info-row">
        <span><?php _e('Vehicle Type', 'access-package-integration'); ?></span>
        <strong><?php echo $data['bodyType']; ?></strong>
    </p>
<?php endif; ?>

<?php if (!empty($data['fuel'])) : ?>
    <p class="tfap-model-info-row">
        <span><?php _e('Fuel', 'access-package-integration'); ?></span>
        <strong><?php echo $data['fuel']; ?></strong>
    </p>
<?php endif; ?>

<?php if (!empty($data['gearBox'])) : ?>
    <p class="tfap-model-info-row">
        <span><?php _e('Gear Box', 'access-package-integration'); ?></span>
        <strong><?php echo $data['gearBox']; ?></strong>
    </p>
<?php endif; ?>

<?php if (!empty($data['modelYear'])) : ?>
    <p class="tfap-model-info-row">
        <span><?php _e('Model Year', 'access-package-integration'); ?></span>
        <strong><?php echo $data['modelYear']; ?></strong>
    </p>
<?php endif; ?>

<?php if (!empty($data['color'])) : ?>
    <p class="tfap-model-info-row">
        <span><?php _e('Color', 'access-package-integration'); ?></span>
        <strong><?php echo $data['color']; ?></strong>
    </p>
<?php endif; ?>

<?php if (!empty($data['make'])) : ?>
    <p class="tfap-model-info-row">
        <span><?php _e('Brand', 'access-package-integration'); ?></span>
        <strong><?php echo $data['make']; ?></strong>
    </p>
<?php endif; ?>

<?php if (!empty($data['model'])) : ?>
    <p class="tfap-model-info-row">
        <span><?php _e('Model', 'access-package-integration'); ?></span>
        <strong><?php echo $data['model']; ?></strong>
    </p>
<?php endif; ?>

<?php if (!empty($data['additionalVehicleData']['cylinderVolumeCC'])) : ?>
    <p class="tfap-model-info-row">
        <span><?php _e('CC', 'access-package-integration'); ?></span>
        <strong><?php echo $data['additionalVehicleData']['cylinderVolumeCC']; ?> cc</strong>
    </p>
<?php endif; ?>

<?php if (!empty($data['equipment'][0])) : ?>
    <h2 class="tfap-mt3 tfap-mb2 tfap-h3 tfap-color-black">
        <?php _e('Equipment', 'access-package-integration'); ?>
    </h2>

    <ul class="tfap-two-col">
        <?php foreach ($data['equipment'] as $equipment) : ?>
            <li><?php echo $equipment; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if (!empty($data['description'])) : ?>
    <div style="font-size:1rem; margin-top: 1rem;"><?php echo $data['description']; ?></div>
<?php endif; ?>