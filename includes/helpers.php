<?php

if (!defined('ABSPATH')) {
    exit;
}

function tfap_format_car_price($price, $append_currency = true)
{
    $price = tf_format_number($price);

    if ($append_currency) {
        $price .= ' kr';
    }

    return $price;
}
function tf_format_number($number, $decimals = 0)
{
    return number_format($number, $decimals, '.', ' ');
}

function tfap_get_svg_image($name)
{
    $arrContextOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
    ];
    $svgFile = file_get_contents(
        sprintf(
            '%s/images/%s.svg',
            TFAP_ASSETS,
            $name
        ),
        false,
        stream_context_create($arrContextOptions)
    );
    $findString = '<svg';
    $svgFile = str_replace('<svg ', '<svg class="tfap-svg-image"', $svgFile);
    $position = strpos($svgFile, $findString);
    $svgFileNew = substr($svgFile, $position);
    return sprintf('<div class="tfap-svg">%s</div>', $svgFileNew);
}

function tfap_get_financial_data(int $carId)
{
    $transientName = sprintf('finance_data_%d', $carId);
    $transient = get_transient($transientName);

    if ($transient !== false) {
        return $transient;
    }

    $response = wp_remote_get(sprintf('https://api.bytbil.com/finance/vehicles/%d', $carId));
    if (200 !== wp_remote_retrieve_response_code($response)) {
        return false;
    }

    $body = wp_remote_retrieve_body($response);

    if ($body === '') {
        return false;
    }

    $jsonBody = json_decode(wp_remote_retrieve_body($response), 1);
    set_transient($transientName, $jsonBody, DAY_IN_SECONDS);

    return $jsonBody;
}

function tfap_server_https()
{
    return ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443);
}
