<?php

namespace TF\AccessPackage;

class Metabox
{
    public static function enqueueAdminAssets()
    {
        if (get_page_template_slug(get_the_ID()) !== 'template-car-archive.php') {
            return;
        }

        wp_enqueue_script('tfap-select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js');
        wp_enqueue_style('tfap-select2-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css');

        wp_enqueue_script(
            'tfap-slect2',
            plugin_dir_url(__FILE__) . '../admin/select2.js',
            ['tfap-select2-js']
        );
    }

    public static function registerMetaBoxes()
    {
        if (get_page_template_slug(get_the_ID()) !== 'template-car-archive.php') {
            return;
        }

        add_meta_box(
            'tfap-preselected-filters',
            __('Archive Filter', 'access-package-integration'),
            [MetaBox::class, 'preSelectedMetaFields'],
            'page'
        );


        if (apply_filters('tfap_hide_single_car_content', true)) {
            add_meta_box(
                'tfap-additional-settings',
                __('Content before car archive', 'access-package-integration'),
                [MetaBox::class, 'additionalInformationMetaFields'],
                'page'
            );
        }

        add_meta_box(
            'tfap-visibility-settings',
            __('Visibility settings', 'access-package-interation'),
            [MetaBox::class, 'visibilityMetaFields'],
            'page',
            'side'
        );

        add_meta_box(
            'tfap-latest-cars-settings',
            __('Show 4 latest cars', 'access-package-interation'),
            [MetaBox::class, 'latestCarsFields'],
            'page',
            'side'
        );

        add_meta_box(
            'tfap-custom-hero-settings',
            __('Custom hero settings', 'access-package-interation'),
            [MetaBox::class, 'customHeroFields'],
            'page',
            'side'
        );
    }

    public static function latestCarsFields()
    {
        $value = get_post_meta(get_the_ID(), 'tfap_latest_cars', true);

        $markup = '';

        $markup .= '<div style="margin-top: 10px;">';
        $markup .= '<input type="checkbox" name="tfap_latest_cars" id="tfap_latest_cars"';
        $markup .= checked($value, true, false);
        $markup .= ' />';

        $markup .= '<label for="tfap_latest_cars" class="components-checkbox-control__label">';
        $markup .= __('Show 4 latest cars', 'access-package-integration');
        $markup .= '</label>';
        $markup .= '</div>';

        echo $markup;
    }

    public static function visibilityMetaFields()
    {
        $value = get_post_meta(get_the_ID(), 'tfap_hide_filters', true);

        $markup = '';

        $markup .= '<div style="margin-top: 10px;">';
        $markup .= '<input type="checkbox" name="tfap_hide_filters" id="tfap_hide_filters"';
        $markup .= checked($value, true, false);
        $markup .= ' />';

        $markup .= '<label for="tfap_hide_filters" class="components-checkbox-control__label">';
        $markup .= __('Hide hero and all filters', 'access-package-integration');
        $markup .= '</label>';
        $markup .= '</div>';

        echo $markup;
    }

    public static function additionalInformationMetaFields()
    {

        $content = get_post_meta(get_the_ID(), 'tfap_content_before_filters', true);

        $markup = '';
        $markup .= '<div style="padding-bottom: 100px; margin-right: 30px; flex-grow: 1; flex-basis: 0;">';
        $markup .= '<textarea class="js-content-before-filters" id="tfap_content_before_filters" name="tfap_content_before_filters" style="width: 100%; border: none;">';
        $markup .= $content;
        $markup .= '</textarea>';
        $markup .= '</div>';

        echo $markup;
    }

    public static function preSelectedMetaFields()
    {
        $markup = '<div style="display: flex;">';
        $markup .= self::makersFields();
        $markup .= self::modelFields();
        $markup .= self::typeFields();
        $markup .= '</div>';
        $markup .= '<div style="display: flex;">';
        $markup .= self::newOrUsedFields();
        $markup .= self::cityFields();
        $markup .= self::leasingFields();
        $markup .= '</div>';
        $markup .= '<div style="display: flex;">';
        $markup .= self::dealerFields();
        $markup .= self::formPriceFields();
        $markup .= self::toPriceFields();
        $markup .= '</div>';

        echo $markup;
    }

    public static function customHeroFields()
    {
        /* Maybe add support for custom hero image here later? */
        $markup = '<div style="display: flex; flex-direction:column;">';
        $markup .= self::removeHeading();
        $markup .= self::cutstomHeading();
        $markup .= '</div>';

        echo $markup;
    }

    private static function cutstomHeading()
    {
        $markup = '';
        $existing_value = get_post_meta(get_the_ID(), 'tfap_custom_hero_title', true) ?: '';

        $markup .= '<div style="padding-bottom: 100px; flex-grow: 1; flex-basis: 0;">';
        $markup .= '<p><label for="tfap_custom_hero_title">' . esc_html__('Custom hero title', 'access-package-integration') . '</label></p>';
        $markup .= '<input id="tfap_custom_hero_title" value="' . $existing_value . '" name="tfap_custom_hero_title" data-allow-clear="true" style="width:100%; padding: 10px;">';
        $markup .= '</div>';

        return $markup;
    }

    private static function removeHeading()
    {
        $value = get_post_meta(get_the_ID(), 'tfap_remove_hero_title', true);

        $markup = '';

        $markup .= '<div style="margin-top: 10px; padding-bottom: 10px; border-bottom: 1px solid #c3c4c7; margin-bottom: 10px; display: flex; align-items: center;">';
        $markup .= '<input type="checkbox" name="tfap_remove_hero_title" id="tfap_remove_hero_title"';
        $markup .= checked($value, true, false);
        $markup .= ' />';

        $markup .= '<label for="tfap_remove_hero_title" class="components-checkbox-control__label" style="margin-top: -3px; padding-left: 3px;">';
        $markup .= __('Remove hero heading', 'access-package-integration');
        $markup .= '</label>';
        $markup .= '</div>';
        return $markup;
    }


    private static function formPriceFields()
    {
        $markup = '';
        $existing_value = get_post_meta(get_the_ID(), 'tfap_from_price', true) ?: false;
        $prices = (new \TF\AccessPackage\FilterFields\Price())->data();
        $markup .= '<div style="padding-bottom: 20px; margin-right: 30px; flex-grow: 1; flex-basis: 0;">';
        $markup .= '<p><label for="tfap_from_price">' . esc_html__('Min price', 'access-package-integration') . '</label></p>';
        $markup .= '<select id="tfap_from_price" name="tfap_from_price" class="js-tfap-multiple-filter" style="width:100%">';

        if (empty($existing_value)) {
            $markup .= '<option value="" disabled selected>Select</option>';
        }
        foreach ($prices['values'] as $data) {
            $selected = $data['value'] === (int) $existing_value;
            $markup .= '<option value="' . $data['value'] . '"' . ($selected ? ' selected="true"' : '') . '>' . esc_html($data['value']) . '</option>';
        }

        $markup .= '</select>';
        $markup .= '</div>';

        return $markup;
    }

    private static function toPriceFields()
    {
        $markup = '';
        $existing_value = get_post_meta(get_the_ID(), 'tfap_to_price', true) ?: false;
        $prices = (new \TF\AccessPackage\FilterFields\Price())->data();
        $markup .= '<div style="padding-bottom: 20px; flex-grow: 1; flex-basis: 0;">';
        $markup .= '<p><label for="tfap_to_price">' . esc_html__('Max price', 'access-package-integration') . '</label></p>';
        $markup .= '<select id="tfap_to_price" name="tfap_to_price" class="js-tfap-multiple-filter" style="width:100%">';

        if (empty($existing_value)) {
            $markup .= '<option value="" disabled selected>Select</option>';
        }
        foreach ($prices['values'] as $data) {
            $selected = $data['value'] === (int) $existing_value;
            $markup .= '<option value="' . $data['value'] . '"' . ($selected ? ' selected="true"' : '') . '>' . esc_html($data['label']) . '</option>';
        }

        $markup .= '</select>';
        $markup .= '</div>';

        return $markup;
    }

    private static function makersFields()
    {
        $markup = '';
        $existing_value = get_post_meta(get_the_ID(), 'tfap_make', true) ?: [];

        $makes = \TF\AccessPackage\Car::values('make');

        $markup .= '<div style="padding-bottom: 20px; margin-right: 30px; flex-grow: 1; flex-basis: 0;">';
        $markup .= '<p><label for="tfap_make">' . esc_html__('Makes', 'access-package-integration') . '</label></p>';
        $markup .= '<select id="tfap_make" name="tfap_make[]" class="js-tfap-multiple-filter" multiple style="width:100%">';

        foreach ($makes as $make) {
            $selected = in_array($make['value'], $existing_value);
            $markup .= '<option value="' . $make['value'] . '"' . ($selected ? ' selected="true"' : '') . '>' . esc_html($make['label']) . '</option>';
        }

        $markup .= '</select>';
        $markup .= '</div>';

        return $markup;
    }

    private static function dealerFields()
    {
        $markup = '';

        $existing_value = get_post_meta(get_the_ID(), 'tfap_dealerName', true) ?: [];
        $dealers = \TF\AccessPackage\Car::values('dealerName');

        $markup .= '<div style="padding-bottom: 20px; margin-right: 30px; flex-grow: 1; flex-basis: 0;">';
        $markup .= '<p><label for="tfap_dealerName">' . esc_html__('Dealer', 'access-package-integration') . '</label></p>';
        $markup .= '<select id="tfap_dealerName" name="tfap_dealerName[]" class="js-tfap-multiple-filter" multiple style="width:100%">';

        foreach ($dealers as $dealer) {
            $selected = in_array($dealer['value'], $existing_value);
            $markup .= '<option value="' . $dealer['value'] . '"' . ($selected ? ' selected="true"' : '') . '>' . esc_html($dealer['label']) . '</option>';
        }

        $markup .= '</select>';
        $markup .= '</div>';

        return $markup;
    }

    private static function newOrUsedFields()
    {
        $markup = '';
        $existing_value = (array) get_post_meta(get_the_ID(), 'tfap_used', true) ?: [];

        $markup .= '<div style="padding-bottom: 20px; margin-right: 30px; flex-grow: 1; flex-basis: 0;">';
        $markup .= '<p><label for="tfap_used">' . esc_html__('New or used', 'access-package-integration') . '</label></p>';
        $markup .= '<select id="tfap_used" name="tfap_used[]" class="js-tfap-multiple-filter" multiple style="width:100%">';
        //$markup .= '<option value="" ' . (in_array('', $existing_value) ? ' selected="true"' : '') . '>' . esc_html__('Select', 'access-package-integration') . '</option>';
        $markup .= '<option value="new" ' . (in_array('new', $existing_value) ? ' selected="true"' : '') . '>' . esc_html__('New cars', 'access-package-integration') . '</option>';
        $markup .= '<option value="used" ' . (in_array('used', $existing_value) ? ' selected="true"' : '') . '>' . esc_html__('Used cars', 'access-package-integration') . '</option>';
        $markup .= '</select>';
        $markup .= '</div>';

        return $markup;
    }

    private static function leasingFields()
    {
        $markup = '';

        $existing_value = (array) get_post_meta(get_the_ID(), 'tfap_leasing', true) ?: [];
        $markup .= '<div style="padding-bottom: 20px; flex-grow: 1; flex-basis: 0;">';
        $markup .= '<p><label for="tfap_leasing">' . esc_html__('Leasing', 'access-package-integration') . '</label></p>';
        $markup .= '<select id="tfap_leasing" name="tfap_leasing[]" class="js-tfap-multiple-filter" multiple style="width:100%">';
        //$markup .= '<option value="" ' . selected('', $existing_value, false) . '>' . esc_html__('Select', 'access-package-integration') . '</option>';
        $markup .= '<option value="1" ' . (in_array('1', $existing_value) ? ' selected="true"' : '') . '>' . esc_html__('Yes', 'access-package-integration') . '</option>';
        $markup .= '<option value="0" ' . (in_array('0', $existing_value) ? ' selected="true"' : '') . '>' . esc_html__('No', 'access-package-integration') . '</option>';
        $markup .= '</select>';
        $markup .= '</div>';

        return $markup;
    }

    private static function cityFields()
    {
        $markup = '';

        $existing_value = get_post_meta(get_the_ID(), 'tfap_city', true) ?: [];
        $cities = \TF\AccessPackage\Car::values('city');

        $markup .= '<div style="padding-bottom: 20px; margin-right: 30px; flex-grow: 1; flex-basis: 0;">';
        $markup .= '<p><label for="tfap_city">' . esc_html__('City', 'access-package-integration') . '</label></p>';
        $markup .= '<select id="tfap_city" name="tfap_city[]" class="js-tfap-multiple-filter" multiple style="width:100%">';

        foreach ($cities as $city) {
            $selected = in_array($city['value'], $existing_value);
            $markup .= '<option value="' . $city['value'] . '"' . ($selected ? ' selected="true"' : '') . '>' . esc_html($city['label']) . '</option>';
        }

        $markup .= '</select>';
        $markup .= '</div>';

        return $markup;
    }

    private static function typeFields()
    {
        $markup = '';

        $types = \TF\AccessPackage\Car::types();
        $existing_value = get_post_meta(get_the_ID(), 'tfap_type', true) ?: [];
        $savedTypeValues = [];

        foreach ($existing_value as $value) {
            $savedTypeValues[] = $value === 'transport' ? 'transportvehicle' : $value;
        }

        $markup .= '<div style="padding-bottom: 20px; flex-grow: 1; flex-basis: 0;">';
        $markup .= '<p><label for="tfap_type">' . esc_html__('Car type', 'access-package-integration') . '</label></p>';
        $markup .= '<select id="tfap_type" name="tfap_type[]" class="js-tfap-multiple-filter" multiple style="width:100%">';

        foreach ($types as $type) {
            $selected = in_array($type['value'], $savedTypeValues);
            $markup .= '<option value="' . $type['value'] . '"' . ($selected ? ' selected="true"' : '') . '>' . esc_html($type['label']) . '</option>';

            if (isset($type['children'])) {
                foreach ($type['children'] as $children_type) {
                    $selected = in_array($children_type['value'], $existing_value);
                    $markup .= '<option value="' . $children_type['value'] . '"' . ($selected ? ' selected="true"' : '') . '>' . esc_html(sprintf('- %s', $children_type['label'])) . '</option>';
                }
            }
        }

        $markup .= '</select>';
        $markup .= '</div>';

        return $markup;
    }

    private static function modelFields()
    {
        $markup = '';

        $models = \TF\AccessPackage\Car::values('model');
        $existing_value = get_post_meta(get_the_ID(), 'tfap_model', true) ?: [];

        $markup .= '<div style="padding-bottom: 20px; margin-right: 30px; flex-grow: 1; flex-basis: 0;">';
        $markup .= '<p><label for="tfap_model">' . esc_html__('Model', 'access-package-integration') . '</label></p>';
        $markup .= '<select id="tfap_model" name="tfap_model[]" class="js-tfap-multiple-filter" multiple style="width:100%">';

        foreach ($models as $model) {
            $selected = in_array($model['value'], $existing_value);
            $markup .= '<option value="' . $model['value'] . '"' . ($selected ? ' selected="true"' : '') . '>' . esc_html($model['label']) . '</option>';

            if (isset($model['children'])) {
                foreach ($model['children'] as $children_model) {
                    $selected = in_array($children_model['value'], $existing_value);
                    $markup .= '<option value="' . $children_model['value'] . '"' . ($selected ? ' selected="true"' : '') . '>' . esc_html(sprintf('- %s', $children_model['label'])) . '</option>';
                }
            }
        }

        $markup .= '</select>';
        $markup .= '</div>';

        return $markup;
    }

    public static function saveMetaBoxes($post_id)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if ($parent_id = wp_is_post_revision($post_id)) {
            $post_id = $parent_id;
        }

        $fields = [
            'tfap_make',
            'tfap_used',
            'tfap_leasing',
            'tfap_city',
            'tfap_type',
            'tfap_model',
            'tfap_from_price',
            'tfap_to_price',
            'tfap_dealerName',
        ];

        foreach ($fields as $field) {
            if (array_key_exists($field, $_POST)) {
                update_post_meta($post_id, $field, $_POST[$field]);
            } else {
                delete_post_meta($post_id, $field);
            }
        }

        if (isset($_POST['tfap_content_before_filters'])) {
            update_post_meta(
                $post_id,
                'tfap_content_before_filters',
                wp_kses_post($_POST['tfap_content_before_filters'])
            );
        }

        if (isset($_POST['tfap_custom_hero_title'])) {
            update_post_meta(
                $post_id,
                'tfap_custom_hero_title',
                wp_kses_post($_POST['tfap_custom_hero_title'])
            );
        }

        if (isset($_POST['tfap_hide_filters'])) {
            update_post_meta($post_id, 'tfap_hide_filters', 'on' === sanitize_key($_POST['tfap_hide_filters']));
        } else {
            update_post_meta($post_id, 'tfap_hide_filters', false);
        }

        if (isset($_POST['tfap_remove_hero_title'])) {
            update_post_meta($post_id, 'tfap_remove_hero_title', 'on' === sanitize_key($_POST['tfap_remove_hero_title']));
        } else {
            update_post_meta($post_id, 'tfap_remove_hero_title', false);
        }

        if (isset($_POST['tfap_latest_cars'])) {
            update_post_meta($post_id, 'tfap_latest_cars', 'on' === sanitize_key($_POST['tfap_latest_cars']));
        } else {
            update_post_meta($post_id, 'tfap_latest_cars', false);
        }
    }
}
