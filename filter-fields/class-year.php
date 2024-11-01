<?php

namespace TF\AccessPackage\FilterFields;

class Year
{
    public function data($post_id = 0)
    {
        return [
            'filterKey' => 'modelYear',
            'title' => esc_html__('Year', 'access-package-integration'),
            'adminTitle' => esc_html__('Year', 'access-package-integration'),
            'field' => 'access_package_filter_show_year',
            'order' => \TF\AccessPackage\Filters::filterOrder('access_package_filter_show_year'),
            'type' => 'range',
            'placeholder' => esc_html__('Select year', 'access-package-integration'),
            'values' => array_map(function ($value) {
                return [
                    'value' => $value,
                    'label' => $value,
                ];
            }, range(date('Y'), 1980)),
        ];
    }
}
