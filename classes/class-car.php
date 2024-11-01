<?php

namespace TF\AccessPackage;

class Car
{
    public static function all()
    {
        $cars = new \WP_Query([
            'post_type' => Sync\Car::$postType,
            'posts_per_page' => -1,
        ]);

        return array_map(function ($car) {
            return self::formatData($car);
        }, $cars->posts);
    }

    private static function formatData($car)
    {
        return [
            'title' => $car->post_title,
            'id' => get_post_meta($car->ID, Sync\Car::$keyExternalId, true),
            'publishedDate' => get_post_meta($car->ID, 'published_date', true),
            'createDate' => get_post_meta($car->ID, 'changed_date', true),
            'permalink' => get_permalink($car->ID),
            'data' => !empty($car->post_content) ?
                (json_decode(stripslashes($car->post_content)) ?
                    json_decode(stripslashes($car->post_content)) :
                    json_decode($car->post_content))
                : null
        ];
    }

    public static function values($property, $post_id = 0)
    {
        $cars = array_filter(self::all(), function ($car) use ($property) {
            if (!empty($car['data']->$property)) {
                return $car['data']->$property !== '';
            }
            return false;
        });

        $default_values = \Tf\AccessPackage\Filters::activeValue($property, $post_id);

        $values = array_map(function ($car) use ($property, $default_values) {
            return [
                'value' => $car['data']->$property,
                'label' => $car['data']->$property,
                'filterType' => $property,
                'default' => in_array($car['data']->$property, (array)$default_values),
            ];
        }, $cars);

        $values = array_unique($values, SORT_REGULAR);

        $values = array_filter($values, function ($value) {
            return !empty($value['value']);
        });

        usort($values, function ($a, $b) {
            return $a['value'] > $b['value'] ? 1 : -1;
        });

        return $values;
    }

    public static function types()
    {
        $type_labels = [
            [
                'value' => 'car',
                'filterType' => 'vehicleType',
                'label' => esc_html__('Car', 'access-package-integration'),
                'children' => [
                    [
                        'value' => 'Sedan',
                        'filterType' => 'bodyType',
                        'label' => 'Sedan',
                    ],
                    [
                        'value' => 'Kombi',
                        'filterType' => 'bodyType',
                        'label' => 'Kombi',
                    ],
                    [
                        'value' => 'Halvkombi',
                        'filterType' => 'bodyType',
                        'label' => 'Halvkombi',
                    ],
                    [
                        'value' => 'Sportkupé',
                        'filterType' => 'bodyType',
                        'label' => 'Sportkupé'
                    ],
                    [
                        'value' => 'SUV',
                        'filterType' => 'bodyType',
                        'label' => 'SUV'
                    ],
                    [
                        'value' => 'Cab',
                        'filterType' => 'bodyType',
                        'label' => 'Cab'
                    ],
                    [
                        'value' => 'Minibuss',
                        'filterType' => 'bodyType',
                        'label' => 'Minibuss'
                    ],
                    [
                        'value' => 'Övrigt',
                        'filterType' => 'bodyType',
                        'label' => 'Övrigt'
                    ]
                ]
            ],
            [
                'value' => 'transportvehicle',
                'filterType' => 'vehicleType',
                'label' => esc_html__('Transport cars', 'access-package-integration'),
                'children' => [
                    [
                        'value' => 'Övrigttransport',
                        'filterType' => 'bodyType',
                        'label' => 'Övrigttransport',
                    ],
                    [
                        'value' => 'Transportbil - Flak',
                        'filterType' => 'bodyType',
                        'label' => 'Transportbil - Flak',
                    ],
                    [
                        'value' => 'Transportbil - Skåp',
                        'filterType' => 'bodyType',
                        'label' => 'Transportbil - Skåp',
                    ],
                ]
            ],
            [
                'value' => 'trailer',
                'filterType' => 'vehicleType',
                'label' => esc_html__('Trailers', 'access-package-integration'),
                'children' => [
                    [
                        'value' => 'Båttrailer',
                        'filterType' => 'bodyType',
                        'label' => 'Båttrailer',
                    ],
                    [
                        'value' => 'Hästsläp',
                        'filterType' => 'bodyType',
                        'label' => 'Hästsläp',
                    ],
                    [
                        'value' => 'Personvagnssläp',
                        'filterType' => 'bodyType',
                        'label' => 'Personvagnssläp',
                    ],
                ]
            ],
            [
                'value' => 'camper',
                'filterType' => 'vehicleType',
                'label' => esc_html__('Camper', 'access-package-integration'),
                'children' => [
                    [
                        'value' => 'Husbil-alkov',
                        'filterType' => 'bodyType',
                        'label' => 'Husbil-alkov'
                    ],
                    [
                        'value' => 'Husbil-halvintegrerad',
                        'filterType' => 'bodyType',
                        'label' => 'Husbil-halvintegrerad'
                    ],
                    [
                        'value' => 'Husbil-integrerad',
                        'filterType' => 'bodyType',
                        'label' => 'Husbil-integrerad'
                    ],
                    [
                        'value' => 'Husbil-övrigt',
                        'filterType' => 'bodyType',
                        'label' => 'Husbil-övrigt'
                    ],
                ]
            ],
            [
                'value' => 'caravan',
                'filterType' => 'vehicleType',
                'label' => esc_html__('Caravan', 'access-package-integration'),
                'children' => [
                    [
                        'value' => 'Husvagn, 1-axl',
                        'filterType' => 'bodyType',
                        'label' => 'Husvagn, 1-axl'
                    ],
                    [
                        'value' => 'Husvagn, 2-axl',
                        'filterType' => 'bodyType',
                        'label' => 'Husvagn, 2-axl'
                    ],
                    [
                        'value' => 'Husvagn-övrigt',
                        'filterType' => 'bodyType',
                        'label' => 'Husvagn-övrigt'
                    ],
                ]
            ],
            [
                'value' => 'mc',
                'filterType' => 'vehicleType',
                'label' => esc_html__('Motorcycle', 'access-package-integration'),
                'children' => [
                    [
                        'value' => 'Touring/Landsväg',
                        'filterType' => 'bodyType',
                        'label' => 'Touring/Landsväg'
                    ],
                    [
                        'value' => 'Sport',
                        'filterType' => 'bodyType',
                        'label' => 'Sport'
                    ],
                    [
                        'value' => 'Custom',
                        'filterType' => 'bodyType',
                        'label' => 'Custom'
                    ],
                    [
                        'value' => 'Cross/Enduro/Trial',
                        'filterType' => 'bodyType',
                        'label' => 'Cross/Enduro/Trial'
                    ],
                    [
                        'value' => 'Offroad',
                        'filterType' => 'bodyType',
                        'label' => 'Offroad'
                    ],
                    [
                        'value' => '4-hjuling',
                        'filterType' => 'bodyType',
                        'label' => '4-hjuling'
                    ],
                    [
                        'value' => 'Scooter',
                        'filterType' => 'bodyType',
                        'label' => 'Scooter'
                    ],
                    [
                        'value' => 'Snöskoter',
                        'filterType' => 'bodyType',
                        'label' => 'Snöskoter'
                    ],
                    [
                        'value' => 'Sidovagn-släp',
                        'filterType' => 'bodyType',
                        'label' => 'Sidovagn-släp'
                    ],
                    [
                        'value' => 'MC-övrigt',
                        'filterType' => 'bodyType',
                        'label' => 'MC-övrigt'
                    ],
                    [
                        'value' => 'Supermotard',
                        'filterType' => 'bodyType',
                        'label' => 'Supermotard'
                    ],
                    [
                        'value' => 'Trike',
                        'filterType' => 'bodyType',
                        'label' => 'Trike'
                    ],
                ]
            ],
            [
                'value' => 'moped',
                'filterType' => 'vehicleType',
                'label' => 'Moped/EU-moped',
                'children' => [
                    [
                        'value' => 'Moped/EU-moped',
                        'filterType' => 'bodyType',
                        'label' => 'Moped/EU-moped'
                    ],
                ]
            ],
        ];

        return self::filterActiveTypes($type_labels);
    }

    private static function availableBodyTypes($cars)
    {
        return array_unique(array_map(function ($car) {
            return $car['data']->bodyType;
        }, $cars));
    }

    private static function availableVehicleTypes($cars)
    {
        return array_unique(array_map(function ($car) {
            return $car['data']->vehicleType;
        }, $cars));
    }

    private static function filterActiveTypes($type_labels)
    {
        $cars = self::all();
        $vehicleTypes = self::availableVehicleTypes($cars);
        $bodyTypes = self::availableBodyTypes($cars);

        $types = array_filter($type_labels, function ($type_label) use ($vehicleTypes) {
            return in_array($type_label['value'], $vehicleTypes);
        });

        return array_map(function ($type_label) use ($bodyTypes) {
            $children = array_filter($type_label['children'], function ($children) use ($bodyTypes) {
                return in_array($children['value'], $bodyTypes);
            });

            usort($children, function ($a, $b) {
                return $a['value'] > $b['value'] ? 1 : -1;
            });

            return [
                'value' => $type_label['value'],
                'label' => $type_label['label'],
                'filterType' => $type_label['filterType'],
                'children' => $children,
            ];
        }, $types);
    }
}
