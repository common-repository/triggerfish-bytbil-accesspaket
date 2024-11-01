<?php

namespace TF\AccessPackage\FilterFields;

use TF\AccessPackage\Car;

class Dealer
{
    public function data($post_id = 0)
    {
        return [
            'filterKey' => 'dealerName',
            'title' => esc_html__('Dealer', 'access-package-integration'),
            'adminTitle' => esc_html__('Dealer', 'access-package-integration'),
            'field' => 'access_package_filter_show_dealer',
            'order' => \TF\AccessPackage\Filters::filterOrder('access_package_filter_show_dealer'),
            'type' => 'multiselect',
            'placeholder' => esc_html__('Select dealer', 'access-package-integration'),
            'values' => Car::values('dealerName', $post_id),
        ];
    }
}
