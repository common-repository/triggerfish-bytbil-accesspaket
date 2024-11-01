<?php

namespace TF\AccessPackage\FilterFields;

use TF\AccessPackage\Car;

class GearBox
{
    public function data($post_id = 0)
    {
        return [
            'filterKey' => 'gearBox',
            'title' => esc_html__('Gear box', 'access-package-integration'),
            'adminTitle' => esc_html__('Gear box', 'access-package-integration'),
            'field' => 'access_package_filter_show_gear_box',
            'order' => \TF\AccessPackage\Filters::filterOrder('access_package_filter_show_gear_box'),
            'type' => 'multiselect',
            'placeholder' => esc_html__('Select gearbox', 'access-package-integration'),
            'values' => Car::values('gearBox', $post_id),
        ];
    }
}
