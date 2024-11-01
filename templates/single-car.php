<?php

if (!defined('ABSPATH')) {
    exit;
}
?>

<?php require_once(TFAP_PLUGIN_DIR . '/includes/helpers.php'); ?>

<?php get_header(); ?>

<?php if (have_posts()) : ?>
    <?php while (have_posts()) : ?>
        <?php the_post(); ?>
        <?php
        $content = get_the_content();
        $data = json_decode($content, true);
        $data = json_decode(stripslashes($content), true) ?
                    json_decode(stripslashes($content), true) :
                    json_decode($content, true);
        $images = $data['images'];
        $price = $data['price'];
        $previousValue = $data['price']['previousValue'];
        $currentPrice = $data['currentPrice'];
        $dealer = $data['dealer'];
        $bodyType = $data['bodyType'];
        $exclusiveVAT =
            !empty($data['price']['showExcludingVat']) &&
            $data['price']['showExcludingVat'] &&
            get_option('access_package_ex_vat_price');

        $title = sprintf('Registreringsnummer: %s, Modell: %s', $data['regNo'], get_the_title());

        $dealerEmail = (!empty($data['accountManager']) && !empty($data['accountManager']['emailAddresses'])) ? implode(',', $data['accountManager']['emailAddresses']) : null;

        if ($dealerEmail === null) {
                $dealerEmail = is_array($dealer['emailAddressesInterest']) ?
                        implode(',', $dealer['emailAddressesInterest']) :
                        $dealer['emailAddressesInterest'];
        }

        $googleLink = sprintf(
            'https://www.google.com/maps/search/?api=1&query=%s+%s+%s',
            $dealer['address']['streetAddress'],
            $dealer['address']['zipcode'],
            $dealer['address']['city']
        );

        $carContent = get_option('access_package_single_car_content');

        if (apply_filters('access_package_hide_single_car_content', false)) {
            $carContent = apply_filters('access_package_content_after_car', null);
        }
        ?>

        <?php require(TFAP_PLUGIN_DIR . '/templates/single-page-parts/single-car-navigation.php'); ?>

        <div class="tfap-container">
            <div class="tfap-row tfap-justify-center">
                <div class="tfap-col-10 tfap-center-text">
                    <p class="tfap-color-black tfap-h3"><?php echo $data['make']; ?></p>
                    <p class="tfap-h2 tfap-color-black tfap-mb3 js-car-title" data-car-id="<?php echo absint($data['id']); ?>" data-dealer-id="<?php echo absint($data['dealer']['id']); ?>"><?php the_title(); ?></p>
                </div>
            </div>
        </div>

        <?php
        if (!empty($images)) {
            require(TFAP_PLUGIN_DIR . '/templates/single-page-parts/slider.php');
        }
        ?>

        <section class="tfap-container-inner">
            <div class="tfap-row">
                <div class="tfap-col-6 tfap-no-padding-mobile tfap-justify-end tfap-order-md-2">
                    <div class="tfap-finance-container tfap-mt1 tfap-md-mt3 ">
                        <?php include(TFAP_PLUGIN_DIR . '/templates/single-page-parts/finance-data.php');
                        ?>
                    </div>
                </div>
                <div class="tfap-col-6 tfap-order-md-1">
                    <?php include(TFAP_PLUGIN_DIR . '/templates/single-page-parts/model-information.php'); ?>
                </div>
            </div>
        </section>

        <?php if (get_option('access_package_enable_dealer_form')) : ?>
            <section id="mail-section" class="tfap-main-bg tfap-mail-section">
                <div class="tfap-container-inner">
                    <div class="tfap-row">
                        <div class="tfap-col">
                            <h3>Intresseanmälan</h3>
                            <form class="js-mail-to">
                                <div class="tfap-row">
                                    <div class="tfap-col-6">
                                        <label for="name">Namn</label>
                                        <input id="name" name="name" type="text" placeholder="Ange ditt namn" required="true" style="margin-bottom: 10px" />

                                        <label for="email">E-post</label>
                                        <input id="email" name="email" type="email" placeholder="Ange din e-post" required="true" style="margin-bottom: 10px" />

                                        <label for="phone">Telefonnummer</label>
                                        <input id="phone" name="phone" type="text" placeholder="Ange ditt telefonnummer" required="true" style="margin-bottom: 10px" />
                                    </div>
                                    <div class="tfap-col-6">
                                        <label for="message">Meddelande</label>
                                        <textarea id="message" name="message" required="true" placeholder="Skriv ditt meddelande"></textarea>

                                        <input type="hidden" name="title" value="<?php echo $title; ?>" />
                                        <input type="hidden" name="dealer" value="<?php echo $dealerEmail; ?>" />
                                        <div class="mail-to-button-container">
                                            <button type="submit" class="js-mail-to-button btn btn-primary">Skicka</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <p class="tf-preamble tf-hidden"><?php
                                echo get_option('access_package_interest_form_message') ?: 'Tack för din intresseanmälan, vi hör av oss.';
                            ?></p>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if (!empty($carContent)) : ?>
            <div class="tfap-container tfap-no-print js-tfap-single-car-content">
                <div class="tfap-row tfap-justify-center">
                    <div class="tfap-col-10 tfap-car-content">
                        <div class="tfap-entry-content">
                            <?php echo apply_filters('the_content', $carContent); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endwhile; ?>
<?php endif; ?>

<?php
get_footer();
