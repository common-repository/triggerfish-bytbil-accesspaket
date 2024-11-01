<?php

if (!defined('ABSPATH')) {
    exit;
}
?>

<section id="tfap-car-image" class="tfap-container tfap-desktop-only tfap-car-slider tfap-no-print">
    <div class="tfap-row">
        <div class="tfap-col-6 tfap-display-flex tfap-no-padding-mobile tfap-slider">
            <button type="button" class="tfap-primary-bg tfap-prev-slide tfap-desktop-only tfap-no-print">
                <?php echo tfap_get_svg_image('chevron-left'); ?>
            </button>
            <div class="tfap-active-image-container">
                <div
                    class="tfap-display-flex tfap-active-image tfap-background-image"
                    data-thumb-key="0"
                    style="background-image: url('<?php echo $images[0]['imageFormats'][0]['url']; ?>');"
                >
                    <div class="tfap-image-ratio"></div>
                </div>
                <span class="tfap-expand tfap-primary-bg tfap-center-text tfap-no-print">+</span>
            </div>
            <div class="tfap-next-image-container tfap-mobile-only">
                <div
                    class="tfap-display-flex tfap-background-image"
                    data-large-img="<?php echo $image['imageFormats'][0]['url']; ?>"
                    style="background-image: url('<?php echo $images[1]['imageFormats'][0]['url']; ?>');"
                >
                    <div class="tfap-image-ratio"></div>
                </div>
            </div>
        </div>
        <div class="tfap-col-6 tfap-display-flex">
            <div class="tfap-slider-thumbs">
                <div class="tfap-image-thumbs-container tfap-row">
                    <?php foreach ($images as $key => $image) : ?>
                        <?php
                        $classes = ['tfap-image-thumb'];
                        if ($key === key($images)) {
                            $classes[] = 'tfap-active-thumb';
                        }

                        $classes[] = $key >= 9 ? 'tfap-hidden-thumb' : 'tfap-image-thumb-visible';
                        ?>
                        <div
                            class="<?php echo implode(' ', $classes); ?>"
                            data-thumb-key="<?php echo $key; ?>"
                            data-large-img="<?php echo $image['imageFormats'][0]['url']; ?>"
                            data-small-img="<?php echo $image['imageFormats'][1]['url']; ?>"
                        >
                            <div
                                class="tfap-background-image"
                                data-large-img="<?php echo $image['imageFormats'][0]['url']; ?>"
                                style="background-image: url('<?php echo $image['imageFormats'][1]['url']; ?>');"
                            >
                                <div class="tfap-image-ratio"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <button type="button" class="tfap-primary-bg tfap-next-slide tfap-no-print tfap-desktop-only">
                <?php echo tfap_get_svg_image('chevron-right'); ?>
            </button>
        </div>
    </div>
</section>

<section id="tfap-light-gallery" class="tfap-container tfap-mobile-only">
    <div class="tfap-row">
        <div class="tfap-col tfap-no-padding-mobile">
            <div class="tfap-mobile-swiper">
                <div class="swiper-wrapper">
                    <?php foreach ($images as $key => $image) : ?>
                        <div class="tfap-swiper-slide swiper-slide" data-thumb-key="<?php echo $key; ?>">
                            <div
                                class="tfap-relative"
                                data-thumb-key="<?php echo $key; ?>"
                                data-large-img="<?php echo $image['imageFormats'][0]['url']; ?>"
                                data-small-img="<?php echo $image['imageFormats'][1]['url']; ?>"
                            >
                                <div class="tfap-image-ratio"></div>
                                <img
                                    class="tfap-absolute-img"
                                    src="<?php echo $image['imageFormats'][0]['url']; ?>"
                                    alt="">
                            </div>
                            <span class="tfap-expand tfap-primary-bg tfap-center-text tfap-no-print">+</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
