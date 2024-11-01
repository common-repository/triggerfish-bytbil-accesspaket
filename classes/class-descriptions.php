<?php

namespace TF\AccessPackage;

class Descriptions
{

    public static function fields()
    {
        return [
            'access_package_description_show__brand' => ['default' => 1, 'label' => esc_html__('Brand', 'access-package-integration')],
            'access_package_description_show__model' => ['default' => 0, 'label' => esc_html__('Model', 'access-package-integration')],
            'access_package_description_show__version' => ['default' => 0, 'label' => esc_html__('Version', 'access-package-integration')],
            'access_package_description_show__year' => ['default' => 1, 'label' => esc_html__('Year', 'access-package-integration')],
            'access_package_description_show__mile' => ['default' => 1, 'label' => esc_html__('Mile', 'access-package-integration')],
            'access_package_description_show__price' => ['default' => 1, 'label' => esc_html__('Price', 'access-package-integration')],
            'access_package_description_show__price_ex_moms' => ['default' => 0, 'label' => esc_html__('Price Ex.moms', 'access-package-integration')],
            'access_package_description_show__price_reduced' => ['default' => 1, 'label' => esc_html__('Reduced price', 'access-package-integration')],
            'access_package_description_show__fuel' => ['default' => 1, 'label' => esc_html__('Fuel', 'access-package-integration')],
            'access_package_description_show__gearbox' => ['default' => 0, 'label' => esc_html__('Gearbox', 'access-package-integration')],
            'access_package_description_show__color' => ['default' => 0, 'label' => esc_html__('Color', 'access-package-integration')],
            'access_package_description_show__location' => ['default' => 0, 'label' => esc_html__('Location', 'access-package-integration')],
            'access_package_description_show__body_type' => ['default' => 0, 'label' => esc_html__('Body type', 'access-package-integration')],
            'access_package_description_show__warranty_program' => ['default' => 0, 'label' => esc_html__('Warranty program', 'access-package-integration')],
            'access_package_description_show__total_weight' => ['default' => 0, 'label' => esc_html__('Total weight', 'access-package-integration')],
        ];
    }

    public static function getDescriptions()
    {
        $descriptions = [];
        $filter_descriptions = self::fields();
        foreach ($filter_descriptions as $name => $data) {
            $descriptions[] = [
                'label' => $data['label'],
                'default' => $data['default'],
                'field' => $name,
            ];
        }
        return $descriptions;
    }
}
