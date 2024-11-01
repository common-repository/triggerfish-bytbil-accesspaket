<?php

namespace TF\AccessPackage\FilterFields;

class Price
{
    public function data($post_id = '')
    {
        $default_from_value = \Tf\AccessPackage\Filters::activeValue('from_price', $post_id) ?? 0;
        $default_to_value = \Tf\AccessPackage\Filters::activeValue('to_price', $post_id) ?? 0;
        $defaultMin = (int)$default_from_value;
        $defaultMax = (int)$default_to_value;
        return [
            'filterKey' => 'currentPrice',
            'title' => esc_html__('Price', 'access-package-integration'),
            'adminTitle' => esc_html__('Price', 'access-package-integration'),
            'field' => 'access_package_filter_show_price',
            'order' => \TF\AccessPackage\Filters::filterOrder('access_package_filter_show_price'),
            'type' => 'range',
            'placeholder' => esc_html__('Select price', 'access-package-integration'),
            'values' => self::values($defaultMin, $defaultMax),
            'defaultValues' => ['values' => [
                'min' => [
                    'value' => $defaultMin,
                    'label' => $defaultMin ?  $defaultMin : 'Från'
                ],
                'max' => [
                    'value' => $defaultMax ?  $defaultMax : 9007199254740991,
                    'label' => $defaultMax ?  $defaultMax : 'Till'
                ]
            ], 'filterType' => 'currentPrice', 'default' => true],
        ];
    }
    private static function values($min, $max)
    {
        $price_range = array_merge(range(10000, 100000, 10000), range(120000, 1000000, 20000));
        return array_map(function ($price) use ($min, $max) {
            return [
                'value' => $price,
                'label' => $price,
                'filterType' => 'currentPrice',
                'defaultMin' => $price === $min,
                'defaultMax' => $price === $max,

            ];
        }, $price_range);
    }
}
