<?php

namespace TF\AccessPackage\FilterFields;

use TF\AccessPackage\Car;

class Beds
{
    public function data($post_id = 0)
    {
        return [
            'filterKey' => 'beds',
            'title' => esc_html__('Number of beds', 'access-package-integration'),
            'adminTitle' => esc_html__('Number of beds (caravan and campers only)', 'access-package-integration'),
            'field' => 'access_package_filter_show_beds',
            'order' => \TF\AccessPackage\Filters::filterOrder('access_package_filter_show_beds'),
            'type' => 'multiselect',
            'placeholder' => esc_html__('Select number of beds', 'access-package-integration'),
            'values' => Car::values('beds', $post_id),
        ];
    }
}
