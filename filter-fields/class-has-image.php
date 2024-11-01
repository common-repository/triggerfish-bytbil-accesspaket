<?php

namespace TF\AccessPackage\FilterFields;

class HasImage
{
    public function data($post_id = 0)
    {
        return [
            'filterKey' => 'hasImage',
            'title' => esc_html__('Only images', 'access-package-integration'),
            'adminTitle' => esc_html__('Only images', 'access-package-integration'),
            'field' => 'access_package_filter_show_has_image',
            'order' => \TF\AccessPackage\Filters::filterOrder('access_package_filter_show_has_image'),
            'type' => 'checkbox',
        ];
    }
}
