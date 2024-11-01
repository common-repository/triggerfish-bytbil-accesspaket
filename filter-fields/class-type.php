<?php

namespace TF\AccessPackage\FilterFields;

use TF\AccessPackage\Car;

class Type
{
    public function data($post_id = 0)
    {
        $default_values = \Tf\AccessPackage\Filters::activeValue('type', $post_id);
        $values = self::values($post_id);

        foreach ($default_values as $key => $value) {
            $default_values[$key] = $value === 'transport' ? 'transportvehicle' : $value;
        }

        foreach ($values as $key => $value) {
            if (in_array($value['value'], (array)$default_values)) {
                $values[$key]['default'] = true;
            }

            foreach ($value['children'] as $children_key => $children_value) {
                if (in_array($children_value['value'], (array)$default_values)) {
                    $values[$key]['children'][$children_key]['default'] = true;
                }
            }
        }

        return [
            'filterKey' => 'vehicleType',
            'title' => esc_html__('Vehicle type', 'access-package-integration'),
            'adminTitle' => esc_html__('Vehicle type', 'access-package-integration'),
            'field' => 'access_package_filter_show_type',
            'order' => \TF\AccessPackage\Filters::filterOrder('access_package_filter_show_type'),
            'type' => 'multiselect',
            'placeholder' => esc_html__('Select type', 'access-package-integration'),
            'hasChildren' => true,
            'values' => $values,
        ];
    }

    private static function values($post_id)
    {
        return Car::types($post_id);
    }
}
