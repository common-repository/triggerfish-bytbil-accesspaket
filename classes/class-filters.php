<?php

namespace TF\AccessPackage;

class Filters
{
    private static $fields = [
        'access_package_filter_show_used' => \TF\AccessPackage\FilterFields\Used::class,
        'access_package_filter_show_type' => \TF\AccessPackage\FilterFields\Type::class,
        'access_package_filter_show_price' => \TF\AccessPackage\FilterFields\Price::class,
        'access_package_filter_show_mileage' => \TF\AccessPackage\FilterFields\Mileage::class,
        'access_package_filter_show_brand' => \TF\AccessPackage\FilterFields\Brand::class,
        'access_package_filter_show_year' => \TF\AccessPackage\FilterFields\Year::class,
        'access_package_filter_show_gear_box' => \TF\AccessPackage\FilterFields\GearBox::class,
        'access_package_filter_show_color' => \TF\AccessPackage\FilterFields\Color::class,
        'access_package_filter_show_fuel' => \TF\AccessPackage\FilterFields\Fuel::class,
        'access_package_filter_show_fwd' => \TF\AccessPackage\FilterFields\FourWheelDrive::class,
        'access_package_filter_show_leasing' => \TF\AccessPackage\FilterFields\Leasing::class,
        'access_package_filter_show_has_image' => \TF\AccessPackage\FilterFields\HasImage::class,
        'access_package_filter_show_city' => \TF\AccessPackage\FilterFields\City::class,
        'access_package_filter_show_beds' => \TF\AccessPackage\FilterFields\Beds::class,
        'access_package_filter_show_length' => \TF\AccessPackage\FilterFields\Length::class,
        'access_package_filter_show_towbar' => \TF\AccessPackage\FilterFields\Towbar::class,
        'access_package_filter_show_model' => \TF\AccessPackage\FilterFields\Model::class,
        'access_package_filter_show_dealer' => \TF\AccessPackage\FilterFields\Dealer::class,
    ];

    private static function getConfig($filter, $post_id = 0)
    {
        $field_obj = new $filter();

        return $field_obj->data($post_id);
    }

    public static function fields()
    {
        return self::$fields;
    }

    public static function fieldsShowMore()
    {
        return array_combine(
            array_map(function ($key) {
                return sprintf('%s_show_more', $key);
            }, array_keys(self::$fields)),
            self::$fields
        );
    }

    public static function active($request = '')
    {
        $post_id = !empty($request->get_param('post_id'))
            ? $request->get_param('post_id') : 0;

        $active_filters = array_filter(self::$fields, function ($field) {
            return get_option($field) ?? false;
        }, ARRAY_FILTER_USE_KEY);

        $show_more_filters = array_filter($active_filters, function ($field) {
            return get_option(sprintf('%s_show_more', $field)) ?? false;
        }, ARRAY_FILTER_USE_KEY);

        $filters = [];
        $filters_show_more = [];
        $hidden_filters = [];

        foreach ($active_filters as $active_filter) {
            $filters[] = self::getConfig($active_filter, $post_id);
        }

        foreach ($show_more_filters as $show_more_filter) {
            $filters_show_more[] = self::getConfig($show_more_filter, $post_id);
        }

        foreach (self::$fields as $k => $f) {
            $isActive = false;
            foreach ($active_filters as $j => $active_filter) {
                if ($j === $k) {
                    $isActive = true;
                    break;
                }
            }

            if (!$isActive) {
                $key = str_replace("access_package_filter_show_", "", $k);
                if ($key === "brand") {
                    $key = "make";
                }
                if ($key === "dealer") {
                    $key = "dealerName";
                }

                if (self::activeValue($key, $post_id)) {
                    $hidden_filters[] = self::getConfig($f, $post_id);
                }
            }
        }

        usort($filters, function ($a, $b) {
            return $a['order'] <=> $b['order'];
        });

        usort($filters_show_more, function ($a, $b) {
            return $a['order'] <=> $b['order'];
        });

        return [
            'filters' => $filters,
            'hidden_filters' => $hidden_filters,
            'config' => Scripts::getConfig($post_id),
        ];
    }

    public static function activeValue($field, $post_id = 0)
    {
        return get_post_meta($post_id, 'tfap_' . $field, true) ?: '';
    }

    public static function filterOrders()
    {
        return get_option('tfap_filter_order');
    }

    public static function filterOrder($filter_field)
    {
        $filter_orders = self::filterOrders();
        if (empty($filter_orders)) {
            return 0;
        }

        return array_search($filter_field, $filter_orders);
    }

    public static function sortedFilters()
    {
        $filter_fields = self::fields();
        $sorted_fields = [];
        $is_sorted = self::filterOrders() ?? false;

        foreach ($filter_fields as $name => $class) {
            $order = self::filterOrder($name);
            $object = new $class();
            $data = $object->data();

            if ($is_sorted && !isset($sorted_fields[$order])) {
                $sorted_fields[$order] = [
                    'label' => $data['adminTitle'],
                    'field' => $name,
                ];
            } else {
                $sorted_fields[] = [
                    'label' => $data['adminTitle'],
                    'field' => $name,
                ];
            }
        }

        ksort($sorted_fields);

        return $sorted_fields;
    }
}
