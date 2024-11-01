<?php

namespace TF\AccessPackage\FilterFields;

class FourWheelDrive
{
    public function data($post_id = 0)
    {
        return [
            'filterKey' => 'fourWheelDrive',
            'title' => esc_html__('Four wheel drive', 'access-package-integration'),
            'adminTitle' => esc_html__('Four wheel drive', 'access-package-integration'),
            'field' => 'access_package_filter_show_fwd',
            'order' => \TF\AccessPackage\Filters::filterOrder('access_package_filter_show_fwd'),
            'type' => 'checkbox',
        ];
    }
}
