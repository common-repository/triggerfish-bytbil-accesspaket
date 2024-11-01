<?php

namespace TF\AccessPackage\FilterFields;

use TF\AccessPackage\Car;

class Mileage
{
    public function data($post_id = 0)
    {
        return [
            'filterKey' => 'milage',
            'title' => esc_html__('Mileage', 'access-package-integration'),
            'adminTitle' => esc_html__('Mileage', 'access-package-integration'),
            'field' => 'access_package_filter_show_mileage',
            'order' => \TF\AccessPackage\Filters::filterOrder('access_package_filter_show_mileage'),
            'type' => 'range',
            'placeholder' => esc_html__('Select mileage', 'access-package-integration'),
            'values' => self::values(),
        ];
    }

    private static function values()
    {
        $values = array_merge(range(500, 10000, 500), range(11000, 20000, 1000), range(25000, 50000, 5000));
        return array_map(function ($value) {
            return [
                'value' => $value,
                'label' => $value,
            ];
        }, $values);
    }
}
