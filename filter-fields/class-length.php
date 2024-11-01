<?php

namespace TF\AccessPackage\FilterFields;

use TF\AccessPackage\Car;

class Length
{
    public function data($post_id = 0)
    {
        return [
            'filterKey' => 'length',
            'title' => esc_html__('Length of vehicle', 'access-package-integration'),
            'adminTitle' => esc_html__('Length of vehicle (caravan and campers only)', 'access-package-integration'),
            'field' => 'access_package_filter_show_length',
            'order' => \TF\AccessPackage\Filters::filterOrder('access_package_filter_show_length'),
            'type' => 'range',
            'placeholder' => esc_html__('Select length of vehicle', 'access-package-integration'),
            'values' => self::values($post_id),
        ];
    }

    private static function values($post_id)
    {
        $lengthValues = Car::values('length', $post_id);
        $values = array_column($lengthValues, 'value');

        $minValue = $values ? floor(min($values)) : 0;
        $maxValue = $values ? round(max($values)) : 1;

        $range = range($minValue, $maxValue);

        return array_map(function ($value) {
            return [
                'value' => $value,
                'label' => sprintf('%s m', $value),
            ];
        }, $range);
    }
}
