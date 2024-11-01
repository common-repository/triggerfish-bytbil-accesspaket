<?php

namespace TF\AccessPackage\FilterFields;

use TF\AccessPackage\Car;

class City
{
    public function data($post_id = 0)
    {
        return [
            'filterKey' => 'city',
            'title' => esc_html__('City', 'access-package-integration'),
            'adminTitle' => esc_html__('City', 'access-package-integration'),
            'field' => 'access_package_filter_show_city',
            'order' => \TF\AccessPackage\Filters::filterOrder('access_package_filter_show_city'),
            'type' => 'multiselect',
            'placeholder' => esc_html__('Select city', 'access-package-integration'),
            'values' => Car::values('city', $post_id),
        ];
    }
}
