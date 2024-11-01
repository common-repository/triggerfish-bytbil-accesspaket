<?php

if (!defined('ABSPATH')) {
    exit;
}

$response = tfap_get_financial_data($data['id']);

printf(
    '<script type="text/javascript">var TFAP_JSON_FINANCES = %s</script>',
    json_encode($response, JSON_PRETTY_PRINT)
);

$cash_upfront_percentage = $response['MinUpfrontInPercent'] / 100;
$cash_min_value = $currentPrice * $cash_upfront_percentage;

$contactEmail = (!empty($data['accountManager']) && !empty($data['accountManager']['emailAddresses'])) ? implode(', ', $data['accountManager']['emailAddresses']) : null;

if ($contactEmail === null) {
    $contactEmail = is_array($dealer['emailAddressesInterest']) ?
        implode(', ', $dealer['emailAddressesInterest']) :
        $dealer['emailAddressesInterest'];
}

function calculateMonthlyFrom($response, $currentPrice)
{
    if (empty($response) || empty($response)) {
        return;
    }

    if (
        empty($response['Rate']) ||
        empty($response['MaxMonths']) ||
        (empty($response['MinUpfrontInPercent']) && $response['MinUpfrontInPercent'] !== 0)
    ) {
        return;
    }

    $rate = floatval($response['Rate']);
    $maxMonths = intval($response['MaxMonths']);
    $minUpfrontInPercent = floatval($response['MinUpfrontInPercent']);
    $periodRate = ($rate / 12) * 0.01;
    $totalRate = pow(1 + $periodRate, $maxMonths);
    $restValue = 0;
    $loanAmount = $currentPrice - ($currentPrice * $minUpfrontInPercent) / 100;
    $monthCost = -(-$loanAmount * $totalRate + $restValue) / (($totalRate - 1) / $periodRate);
    return ceil($monthCost);
}
$priceExclusiveVAT = $currentPrice * 0.8;

$payment_per_month = calculateMonthlyFrom($response, $currentPrice);
$leasingSuffix = !empty($data['leasing']) && $data['leasing'] ? "/mån" : "";
?>

<div id="tfap-price-container" class="tfap-primary-bg tfap-center-text" data-car-price="<?php echo $currentPrice; ?>" data-car-model-year="<?php echo $modelYear; ?>" data-repayment-months="<?php echo $response['DefaultMonthsSalvageValue']; ?>" data-car-cash="<?php echo $cash_min_value; ?>">
    <p class="tfap-h2 tfap-color-white tfap-print-color-black"><?php echo tfap_format_car_price($currentPrice); ?></p>
    <?php if (!empty($previousValue)) : ?>
        <p class="tfap-h4 tfap-line-through tfap-color-white tfap-print-color-black">
            <?php echo tfap_format_car_price($previousValue); ?>
            <?php if (!empty($data['leasing']) && $data['leasing']) {
                echo "/mån";
            } ?>
        </p>
    <?php endif; ?>
    <?php if ($response !== false && !$data['leasing'] && !empty($payment_per_month) && !get_option('access_package_finance_hide_monthly_price')) : ?>
        <p class="tfap-h5 tfap-mt1 tfap-color-white tfap-print-color-black">
            <?php
            printf(
                __('From %s kr/mon', 'access-package-integration'),
                tfap_format_car_price($payment_per_month, false)
            );
            ?>
        </p>
    <?php endif; ?>
    <?php if (!empty($exclusiveVAT)) : ?>
        <p class="tfap-h5 tfap-color-white tfap-print-color-black">
            <?php echo sprintf("(%s%s ex. moms)", tfap_format_car_price($priceExclusiveVAT), $leasingSuffix); ?>
        </p>
    <?php endif; ?>
</div>

<div class="tfap-finance-data">
    <?php if (get_option('access_package_dnb_integration') && get_option('access_package_dnb_dealer_id')) : ?>
        <button class="dnb-button js-dnb-button" data-dealer-id="<?php echo esc_html(get_option('access_package_dnb_dealer_id')); ?>">
            <?php if (get_option('access_package_dnb_button_text')) : ?>
                <?php echo esc_html(get_option('access_package_dnb_button_text')); ?>
            <?php else: ?>
                <?php esc_html_e('Buy online', 'access-package-integration'); ?>
            <?php endif; ?>
        </button>
    <?php endif; ?>

    <?php if ($dealer['phoneNumber']) :
        $phoneNumber = strval($dealer['phoneNumber'])[0] === '0' ? $dealer['phoneNumber'] : '0' . $dealer['phoneNumber'];
        ?>
        <div class="tfap-contact-phone tfap-display-flex tfap-mb2 tfap-no-print">
            <a class="tfap-display-flex tfap-align-items-center tfap-icon-container tfap-h5" href="tel:<?php echo $phoneNumber; ?>">
                <span class="tfap-icon tfap-display-flex"><?php echo tfap_get_svg_image('phone'); ?></span>
                <?php echo $phoneNumber; ?>
            </a>
        </div>
        <span class="tfap-print-only">
            <?php
            printf(
                __('Phone: %s', 'access-package-integration'),
                $dealer['phoneNumber']
            );
            ?>
        </span>
    <?php endif; ?>

    <?php if (get_option('access_package_scroll_to_mail') || get_option('access_package_enable_dealer_form')) : ?>
        <div class="tfap-contact-email tfap-display-flex tfap-mb2 tfap-no-print">
            <a class="tfap-display-flex tfap-align-items-center tfap-icon-container tfap-h5" style="cursor: pointer;" onclick="(function() {
                const selector = '<?php echo get_option('access_package_enable_dealer_form') ? '#mail-section' : '.js-tfap-single-car-content'; ?>';
                var content = document.querySelector(selector).scrollIntoView();
                return false;
            })(); return false;">
                <span class="tfap-icon tfap-display-flex"><?php echo tfap_get_svg_image('mail'); ?></span>
                <?php _e('Email us', 'access-package-integration'); ?>
            </a>
        </div>
    <?php else : ?>
        <?php if ($contactEmail) : ?>
            <div class="tfap-contact-email tfap-display-flex tfap-mb2 tfap-no-print">
                <a class="tfap-display-flex tfap-align-items-center tfap-icon-container tfap-h5" href="mailto:<?php echo $contactEmail; ?>">
                    <span class="tfap-icon tfap-display-flex"><?php echo tfap_get_svg_image('mail'); ?></span>
                    <?php _e('Email us', 'access-package-integration'); ?>
                </a>
            </div>
            <span class="tfap-print-only">E-mail: <?php echo $contactEmail; ?></span>
        <?php endif; ?>
    <?php endif; ?>
    <?php if ($googleLink) : ?>
        <div class="tfap-contact-location tfap-display-flex tfap-mb2 tfap-no-print">
            <a class="tfap-display-flex tfap-align-items-center tfap-icon-container tfap-h5" target="_blank" href="<?php echo $googleLink; ?>">
                <span class="tfap-icon tfap-display-flex"><?php echo tfap_get_svg_image('location'); ?></span>
                <?php _e('Directions', 'access-package-integration'); ?>
            </a>
        </div>
        <span class="tfap-print-only">
            <?php
            printf(
                __('Address: %s, %s %s', 'access-package-integration'),
                $dealer['address']['streetAddress'],
                $dealer['address']['zipcode'],
                mb_strtolower($dealer['address']['city'])
            );
            ?>
        </span>
    <?php endif; ?>

    <?php if ($response !== false && !$data['leasing']) : ?>
        <p class="tfap-mt3 tfap-mb2 tfap-h3 tfap-print-page-break">
            <?php _e('Financing', 'access-package-integration'); ?>
        </p>
        <div class="tfap-mb3 tfap-relative">
            <p class="tfap-slider-title"><?php _e('Down payment', 'access-package-integration'); ?></p>
            <div class="tfap-range-slider tfap-no-print" data-min="<?php echo $cash_min_value; ?>" data-max="<?php echo $currentPrice; ?>" data-step="10000" data-start="<?php echo $cash_min_value; ?>">
                <div class="slider"></div>
            </div>
            <div class="tfap-js-down-payment-value tfap-value-label">
                <span><?php echo $cash_min_value; ?></span> <?php _e('kr', 'access-package-integration'); ?>
            </div>
        </div>
        <div class="tfap-mb3 tfap-relative">
            <p class="tfap-slider-title"><?php _e('Payback', 'access-package-integration'); ?></p>
            <div class="tfap-range-slider tfap-no-print" data-min="<?php echo $response['MinMonths']; ?>" data-max="<?php echo $response['MaxMonths']; ?>" data-step="12" data-start="<?php echo $response['DefaultMonthsSalvageValue']; ?>"></div>
            <div class="tfap-js-payment-plan-value tfap-value-label">
                <span><?php echo $response['MaxMonths']; ?></span> <?php _e('mån', 'access-package-integration'); ?>
            </div>
        </div>
        <div class="tfap-mb3 tfap-relative">
            <p class="tfap-slider-title"><?php _e('Residual', 'access-package-integration'); ?></p>
            <div id="tfap-residual-value" class="tfap-range-slider tfap-no-print" data-min="0" data-max="50" data-step="10" data-start="0" disabled="true"></div>
            <div class="tfap-no-js-value tfap-value-label"><span class="tfap-js-arrear-value">0</span> %</div>
        </div>
        <table id="tfap-vehicle-data" class="data-finance table-full-width">
            <tbody>
                <tr>
                    <th><?php _e('Monthly cost', 'access-package-integration'); ?></th>
                    <td>
                        <span class="tfap-js-monthly-payment-value">
                            <?php echo tfap_format_car_price($payment_per_month, false); ?>
                        </span> <?php _e('kr', 'access-package-integration'); ?>
                    </td>
                </tr>
                <tr>
                    <th><?php _e('Down payment', 'access-package-integration'); ?></th>
                    <td>
                        <span class="tfap-js-down-payment-value">
                            <?php echo $cash_min_value; ?>
                        </span> <?php _e('kr', 'access-package-integration'); ?>
                    </td>
                </tr>
                <tr>
                    <th><?php _e('Payback', 'access-package-integration'); ?></th>
                    <td>
                        <span class="tfap-js-payment-plan-value">
                            <?php echo $response['DefaultMonthsSalvageValue']; ?>
                        </span> <?php _e('mån', 'access-package-integration'); ?>
                    </td>
                </tr>
                <tr>
                    <th><?php _e('Residual', 'access-package-integration'); ?></th>
                    <td>
                        <span class="tfap-js-arrear-value">
                            0
                        </span> <?php _e('kr', 'access-package-integration'); ?>
                    </td>
                </tr>
                <tr>
                    <th><?php _e('Interest', 'access-package-integration'); ?></th>
                    <td>
                        <span class="tfap-js-payment-base-rate">
                            <?php echo $response['Rate']; ?>
                        </span> %
                    </td>
                </tr>
                <tr>
                    <th><?php _e('Effective interest rate', 'access-package-integration'); ?></th>
                    <td>
                        <span class="tfap-js-apr">
                            <?php echo $response['Rate']; ?>
                        </span> %
                    </td>
                </tr>
                <tr>
                    <th><?php _e('Arrangement fee', 'access-package-integration'); ?></th>
                    <td>
                        <span>
                            <?php echo $response['StartFee']; ?>
                        </span> <?php _e('kr', 'access-package-integration'); ?>
                    </td>
                </tr>
                <tr>
                    <th><?php _e('Administration fee', 'access-package-integration'); ?></th>
                    <td>
                        <span>
                            <?php echo $response['MonthlyFee']; ?>
                        </span> <?php _e('kr', 'access-package-integration'); ?>
                    </td>
                </tr>
            </tbody>
        </table>
    <?php endif; ?>
</div>
