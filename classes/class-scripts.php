<?php

namespace TF\AccessPackage;

class Scripts
{
    public static function loadScripts()
    {
        add_filter('script_loader_tag', function ($tag, $handle) {
            if (!preg_match('/^tfap-/', $handle)) {
                return $tag;
            }
            return str_replace(' src', ' async defer src', $tag);
        }, 10, 2);

        add_action('wp_enqueue_scripts', function () {
            if (get_page_template_slug() === 'template-car-archive.php') {
                $asset_manifest = json_decode(file_get_contents(TFAP_ASSET_MANIFEST), true)['files'];
                $build_dir = TFAP_PLUGIN_URL . '/frontend/build';

                if (isset($asset_manifest['main.css'])) {
                    wp_enqueue_style('tfap', $build_dir . $asset_manifest['main.css']);
                }

                wp_enqueue_script('tfap-runtime', $build_dir . $asset_manifest['runtime-main.js'], [], null, true);

                wp_enqueue_script('tfap-runtime', $build_dir . $asset_manifest['runtime-main.js'], [], null, true);

                wp_enqueue_script('tfap-main', $build_dir . $asset_manifest['main.js'], ['tfap-runtime'], null, true);

                wp_localize_script('tfap-main', 'tfap', [
                    'config' => self::getConfig(),
                ]);

                foreach ($asset_manifest as $key => $value) {
                    if (preg_match('@static/js/(.*)\.chunk\.js@', $key, $matches)) {
                        if ($matches && is_array($matches) && count($matches) === 2) {
                            $name = "tfap-" . preg_replace('/[^A-Za-z0-9_]/', '-', $matches[1]);
                            wp_enqueue_script($name, $build_dir . $value, ['tfap-main'], null, true);
                        }
                    }

                    if (preg_match('@static/css/(.*)\.chunk\.css@', $key, $matches)) {
                        if ($matches && is_array($matches) && count($matches) == 2) {
                            $name = "tfap-" . preg_replace('/[^A-Za-z0-9_]/', '-', $matches[1]);
                            wp_enqueue_style($name, $build_dir . $value, ['tfap'], null);
                        }
                    }
                }
            }

            if (is_singular(Sync\Car::$postType)) {
                \wp_enqueue_script(
                    'car-scripts',
                    sprintf('%s/assets/dist/main.js', TFAP_PLUGIN_URL),
                    [],
                    '1.0.0',
                    true
                );

                \wp_enqueue_script(
                    'car-vendor-scripts',
                    sprintf('%s/assets/dist/vendors~main.js', TFAP_PLUGIN_URL),
                    [],
                    '1.0.0',
                    true
                );

                wp_localize_script('car-scripts', 'tfap', [
                    'config' => [
                        'primaryColor' => apply_filters(
                            'access_package_primary_color',
                            get_option('access_package_primary_color')
                        ),
                        'altColor' => apply_filters(
                            'access_package_alt_color',
                            get_option('access_package_alt_color')
                        ),
                        'textColor' => apply_filters(
                            'access_package_primary_text_color',
                            get_option('access_package_text_color')
                        ),
                        'fontFamily' => apply_filters(
                            'access_package_font_family',
                            sprintf('"%s"', get_option('access_package_font_family'))
                        ),
                        'customSuccessMessage' => apply_filters(
                            'access_package_interest_form_message',
                            get_option('access_package_interest_form_message')
                        ),
                        'postId' => get_queried_object_id(),
                        'ajaxUrl' => admin_url('admin-ajax.php'),
                        'financeBgColor' => get_option('access_package_finance_bg_color'),
                        'financeTextColor' => get_option('access_package_finance_text_color'),
                    ],
                ]);

                \wp_enqueue_style(
                    'car-styles',
                    sprintf('%s/assets/dist/main.css', TFAP_PLUGIN_URL),
                    [],
                    '1.0.0'
                );

                \wp_enqueue_style(
                    'car-vendor-styles',
                    sprintf('%s/assets/dist/vendors~main.css', TFAP_PLUGIN_URL),
                    ['car-styles'],
                    '1.0.0'
                );
            }

            if (
                is_singular(Sync\Car::$postType) ||
                get_page_template_slug() === 'template-car-archive.php'
            ) {
                $custom_font = get_option('access_package_font_family');
                if ($custom_font !== 'inherit') {
                    $custom_font = str_replace(' ', '+', $custom_font);
                    wp_enqueue_style('tfap_custom_font', 'https://fonts.googleapis.com/css?family=' . $custom_font . ':400,500,600,700&display=swap');
                }
            }
        });

        add_action('admin_enqueue_scripts', function () {
            $screen = get_current_screen();

            if (
                isset($screen->id) &&
                ($screen->id !== 'settings_page_access-package' && $screen->id !== 'page')
            ) {
                return;
            }

            $script = 'https://cdn.jsdelivr.net/npm/@shopify/draggable@1.0.0-beta.6/lib/sortable.js';

            wp_enqueue_style('wp-color-picker');
            wp_enqueue_media();
            wp_enqueue_editor();

            wp_register_script('tfap-sortable', $script);
            wp_register_script(
                'tfap-admin-js',
                plugin_dir_url(__FILE__) . '../admin/main.js',
                ['tfap-sortable', 'wp-color-picker']
            );
            wp_enqueue_script('tfap-admin-js');
        });
    }

    public static function getConfig($postID = "")
    {
        $postID = !empty($postID) ? $postID : get_queried_object_id();
        $fontFamily = get_option('access_package_font_family');

        if ('inherit' !== $fontFamily) {
            $fontFamily = sprintf('"%s"', $fontFamily);
        }

        return [
            'primaryColor' => apply_filters(
                'access_package_primary_color',
                get_option('access_package_primary_color')
            ),
            'altColor' => apply_filters(
                'access_package_alt_color',
                get_option('access_package_alt_color')
            ),
            'textColor' => apply_filters(
                'access_package_primary_text_color',
                get_option('access_package_text_color')
            ),
            'fontFamily' => apply_filters('access_package_font_family', $fontFamily),
            'postId' => $postID,
            'visibleFields' => self::getDescriptions(),
            'heroImage' => get_option('access_package_hero_background_image') ?
                wp_get_attachment_image_src(
                    get_option('access_package_hero_background_image'),
                    'full'
                )[0] : false,
            'fallbackImage' => get_option('access_package_custom_fallback_image') ?
            wp_get_attachment_image_src(
                get_option('access_package_custom_fallback_image'),
                'full'
            )[0] : false,

            'heading' => self::getHeroTitle($postID),
            'showHeading' => self::getShowHeroTitle($postID),
            'headingSize' => strtolower(get_option('access_package_custom_heading_size') ?? 'H1'),
            'hiddenFilters' => '1' === get_post_meta($postID, 'tfap_hide_filters', true),
            'showLatestCars' => '1' === get_post_meta($postID, 'tfap_latest_cars', true),
            'apiUrl' => sprintf('%s/accesspackage/v1', untrailingslashit(get_rest_url())),
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'pluginUrl' => TFAP_PLUGIN_URL,
            'dnbEnabled' => get_option('access_package_dnb_integration'),
            'dnbDealerId' => get_option('access_package_dnb_dealer_id'),
            'dnbButtonText' => get_option('access_package_dnb_button_text'),
            'financeBgColor' => get_option('access_package_finance_bg_color'),
            'financeTextColor' => get_option('access_package_finance_text_color'),
            'financeHideMonthlyPrice' => get_option('access_package_finance_hide_monthly_price'),
            'showExVAT' => get_option('access_package_ex_vat_price'),
            'maxFilterMobile' => (int) get_option('access_package_filters_max_displayed_mobile'),
            'maxFilterDesktop' => (int) get_option('access_package_filters_max_displayed_desktop'),
            'customSuccessMessage' => apply_filters(
                'access_package_interest_form_message',
                get_option('access_package_interest_form_message')
            ),
            'tightLayout' => get_option('access_package_tight_layout'),
        ];
    }

    public static function getDescriptions()
    {
        $descriptions = [];
        foreach (\TF\AccessPackage\Descriptions::getDescriptions() as $description) {
            $label = explode('__', $description['field']);
            $descriptions[$label[1]] = intval(get_option($description['field']));
        };
        return $descriptions;
    }

    /* Page setting local > Theme setting global > Page title */
    public static function getHeroTitle($postID)
    {
        $page_setting_local = get_post_meta($postID, 'tfap_custom_hero_title', true);
        $theme_setting_global = get_option('access_package_custom_heading');
        $global_or_page_title = !empty($theme_setting_global) ? $theme_setting_global : get_the_title($postID);
        $hero_title = !empty($page_setting_local) ? $page_setting_local : $global_or_page_title;
        return $hero_title;
    }
    public static function getShowHeroTitle($postID)
    {
        return get_post_meta($postID, 'tfap_remove_hero_title', true);
    }
}
