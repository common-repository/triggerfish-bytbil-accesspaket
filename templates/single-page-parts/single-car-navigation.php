<?php

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="tfap-container tfap-no-print">
    <div class="tfap-row tfap-flex tfap-justify-between tfap-mb3 tfap-mt3">
        <div class="tfap-col-auto">
            <?php
            $tfap_referer = parse_url(htmlspecialchars($_SERVER['HTTP_REFERER']));
            if (strpos($tfap_referer['host'], $tfap_referer['host']) !== false) :
            ?>
                <a class="tfap-navigation tfap-primary-icon" href="#" onclick="history.go(-1); return false">
                    <?php echo tfap_get_svg_image('chevron-left'); ?>
                    <span><?php _e('Back', 'access-package-integration'); ?></span>
                </a>
            <?php endif; ?>
        </div>
        <div class="tfap-col-auto">
            <div class="tfap-navigation tfap-share">
                <?php echo tfap_get_svg_image('share'); ?>
                <span class="tfap-desktop-only"><?php _e('Share', 'access-package-integration'); ?></span>
                <div class="tfap-hidden tfap-share-icons tfap-flex">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_the_permalink(); ?>" target="_blank">
                        <?php echo tfap_get_svg_image('facebook'); ?>
                    </a>
                    <a href="https://twitter.com/home?status=<?php echo get_the_permalink(); ?>/webtools/sharelink/ " target="_blank">
                        <?php echo tfap_get_svg_image('twitter'); ?>
                    </a>
                    <a href="mailto:info@example.com?&subject=&body=<?php echo get_the_permalink(); ?>" target="_blank">
                        <?php echo tfap_get_svg_image('mail'); ?>
                    </a>
                </div>
            </div>
            <div class="tfap-navigation" onclick="window.print(); return false">
                <?php echo tfap_get_svg_image('print'); ?>
                <span class="tfap-desktop-only"><?php _e('Print', 'access-package-integration'); ?></span>
            </div>
        </div>
    </div>
</div>
