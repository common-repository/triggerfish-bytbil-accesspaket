<?php

namespace TF\AccessPackage\FilterFields;

class Leasing
{
    public function data($post_id = 0)
    {
        $default_value = (array)\Tf\AccessPackage\Filters::activeValue('leasing', $post_id);

        return [
            'filterKey' => 'leasing',
            'title' => esc_html__('Leasing', 'access-package-integration'),
            'adminTitle' => esc_html__('Leasing', 'access-package-integration'),
            'field' => 'access_package_filter_show_leasing',
            'order' => \TF\AccessPackage\Filters::filterOrder('access_package_filter_show_leasing'),
            'type' => 'select',
            'placeholder' => esc_html__('Select leasing', 'access-package-integration'),
            'values' => [
                [
                    'value' => '',
                    'label' => esc_html__('All cars', 'access-package-integration'),
                    'filterType' => 'leasing',
                    'default' => in_array(1, $default_value) && in_array(0, $default_value),
                ],
                [
                    'value' => 1,
                    'label' => esc_html__('Yes', 'access-package-integration'),
                    'filterType' => 'leasing',
                    'default' => in_array(1, $default_value) && !in_array(0, $default_value),
                ],
                [
                    'value' => 0,
                    'label' => esc_html__('No', 'access-package-integration'),
                    'filterType' => 'leasing',
                    'default' => in_array(0, $default_value) && !in_array(1, $default_value),
                ],
            ],
        ];
    }
}
