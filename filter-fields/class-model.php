<?php

namespace TF\AccessPackage\FilterFields;

use TF\AccessPackage\Car;

class Model
{
    public function data($post_id = 0)
    {
        return [
            'filterKey' => 'model',
            'title' => esc_html__('Model', 'access-package-integration'),
            'adminTitle' => esc_html__('Model', 'access-package-integration'),
            'field' => 'access_package_filter_show_model',
            'order' => \TF\AccessPackage\Filters::filterOrder('access_package_filter_show_model'),
            'type' => 'multiselect',
            'placeholder' => esc_html__('Select model', 'access-package-integration'),
            'values' => Car::values('model', $post_id),
        ];
    }
}
