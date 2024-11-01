<?php

if (!defined('ABSPATH')) {
    exit;
}
?>

<?php get_header(); ?>

<?php $content = get_post_meta(get_the_ID(), 'tfap_content_before_filters', true); ?>
<?php $inlinePadding = "1" !== get_post_meta(get_the_ID(), 'tfap_hide_filters', true) ? 'padding: 70px 0;' : ''; ?>
<?php if ($content) : ?>
    <div class="tfap-container tfap-no-print">
        <div class="tfap-row tfap-justify-center">
            <div class="tfap-col-10 tfap-car-content" style="<?php echo $inlinePadding; ?> width: 83.3333%">
                <div class="tfap-entry-content">
                    <?php echo wpautop($content); ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div id="tfap-root" class="tfap-app" style="padding-bottom: 70px;"></div>

<?php if (have_posts()) : ?>
    <?php while (have_posts()) : ?>
        <?php the_post(); ?>
        <?php if (!empty(trim(get_the_content()))) : ?>
            <div class="tfap-container tfap-no-print">
                <div class="tfap-row tfap-justify-center">
                    <div class="tfap-col-10 tfap-car-content" style="padding-bottom: 70px; width: 83.3333%">
                        <div class="tfap-entry-content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endwhile; ?>
<?php endif; ?>

<?php if (function_exists('have_rows') && have_rows('page_components')) : ?>
    <?php while (have_rows('page_components')) : ?>
        <?php the_row(); ?>

        <?php get_template_part(sprintf('components/%1$s/%1$s', str_replace('_', '-', get_row_layout()))); ?>
    <?php endwhile; ?>
<?php endif; ?>

<?php
get_footer();
