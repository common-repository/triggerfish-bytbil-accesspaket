<?php

namespace TF\AccessPackage\FilterFields;

class Used
{
    public function data($post_id = 0)
    {
        $default_value = (array)\Tf\AccessPackage\Filters::activeValue('used', $post_id);
        return [
            'filterKey' => 'usedState',
            'title' => esc_html__('New or used', 'access-package-integration'),
            'adminTitle' => esc_html__('New or used', 'access-package-integration'),
            'field' => 'access_package_filter_show_used',
            'order' => \TF\AccessPackage\Filters::filterOrder('access_package_filter_show_used'),
            'type' => 'select',
            'placeholder' => esc_html__('Select used', 'access-package-integration'),
            'values' => [
                [
                    'value' => '',
                    'label' => esc_html__('New and used', 'access-package-integration'),
                    'filterType' => 'usedState',
                    'default' => in_array('new', $default_value) && in_array('used', $default_value),
                ],
                [
                    'value' => 'new',
                    'label' => esc_html__('New', 'access-package-integration'),
                    'filterType' => 'usedState',
                    'default' => in_array('new', $default_value) && !in_array('used', $default_value),
                ],
                [
                    'value' => 'old',
                    'label' => esc_html__('Old', 'access-package-integration'),
                    'filterType' => 'usedState',
                    'default' => in_array('used', $default_value) && !in_array('new', $default_value),
                ],
            ],
        ];
    }
}
