<?php

namespace TF\AccessPackage\FilterFields;

use TF\AccessPackage\Car;

class Color
{
    public function data($post_id = 0)
    {
        return [
            'filterKey' => 'colorGroup',
            'title' => esc_html__('Color', 'access-package-integration'),
            'adminTitle' => esc_html__('Color', 'access-package-integration'),
            'field' => 'access_package_filter_show_color',
            'order' => \TF\AccessPackage\Filters::filterOrder('access_package_filter_show_color'),
            'type' => 'multiselect',
            'placeholder' => esc_html__('Select color', 'access-package-integration'),
            'values' => Car::values('colorGroup', $post_id),
        ];
    }
}
