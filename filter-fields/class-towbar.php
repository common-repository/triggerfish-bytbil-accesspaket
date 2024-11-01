<?php

namespace TF\AccessPackage\FilterFields;

class Towbar
{
    public function data($post_id = 0)
    {
        return [
            'filterKey' => 'towBar',
            'title' => esc_html__('Towbar', 'access-package-integration'),
            'adminTitle' => esc_html__('Towbar', 'access-package-integration'),
            'field' => 'access_package_filter_show_towbar',
            'order' => \TF\AccessPackage\Filters::filterOrder('access_package_filter_show_towbar'),
            'type' => 'checkbox',
        ];
    }
}
