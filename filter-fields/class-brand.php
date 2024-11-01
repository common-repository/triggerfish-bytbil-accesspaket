<?php

namespace TF\AccessPackage\FilterFields;

use TF\AccessPackage\Car;

class Brand
{
    public function data($post_id = 0)
    {
        return [
            'filterKey' => 'make',
            'title' => esc_html__('Brand', 'access-package-integration'),
            'adminTitle' => esc_html__('Brand', 'access-package-integration'),
            'field' => 'access_package_filter_show_brand',
            'order' => \TF\AccessPackage\Filters::filterOrder('access_package_filter_show_brand'),
            'type' => 'multiselect',
            'placeholder' => esc_html__('Select brand', 'access-package-integration'),
            'values' => Car::values('make', $post_id),
        ];
    }
}
