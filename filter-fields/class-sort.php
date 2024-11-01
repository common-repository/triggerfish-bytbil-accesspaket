<?php

namespace TF\AccessPackage\FilterFields;

class Sort
{
    public function data($post_id = 0)
    {
        return [
            'filterKey' => 'sort',
            'title' => esc_html__('Sort', 'access-package-integration'),
            'adminTitle' => esc_html__('Sort', 'access-package-integration'),
            'field' => 'access_package_filter_show_sort',
            'order' => \TF\AccessPackage\Filters::filterOrder('access_package_filter_show_sort'),
            'type' => 'select',
            'placeholder' => esc_html__('Select sort', 'access-package-integration'),
            'values' => [
                [
                    'value' => '',
                    'label' => esc_html__('Arrivals', 'access-package-integration'),
                    'default' => true,
                ],
                [
                    'value' => DAY_IN_SECONDS,
                    'label' => esc_html__('Last 24 hours', 'access-package-integration')
                ],
                [
                    'value' => (DAY_IN_SECONDS * 2),
                    'label' => esc_html__('Last 48 hours', 'access-package-integration')
                ],
                [
                    'value' => (DAY_IN_SECONDS * 7),
                    'label' => esc_html__('Last week', 'access-package-integration')
                ],
            ],
        ];
    }
}
