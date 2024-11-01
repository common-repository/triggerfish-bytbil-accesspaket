<?php

namespace TF\AccessPackage\FilterFields;

use TF\AccessPackage\Car;

class Fuel
{
    public function data($post_id = 0)
    {
        return [
            'filterKey' => 'fuel',
            'title' => esc_html__('Fuel', 'access-package-integration'),
            'adminTitle' => esc_html__('Fuel', 'access-package-integration'),
            'field' => 'access_package_filter_show_gear_box',
            'order' => \TF\AccessPackage\Filters::filterOrder('access_package_filter_show_gear_box'),
            'type' => 'multiselect',
            'placeholder' => esc_html__('Select fuel', 'access-package-integration'),
            'values' => Car::values('fuel', $post_id),
        ];
    }
}
