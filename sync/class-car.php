<?php

namespace TF\AccessPackage\Sync;

class Car
{
    public static $keyExternalId = 'external_id';
    public static $postType = 'tf_car';
    public static $towbarSearchWord = 'dragkrok';
    public $postId;

    private $metaKeys = [
        'id',
        'enginePower',
        'gearBox',
        'fuel',
        'co2Emissions',
        'isEco',
        'vehicleType',
        'bodyType',
        'color',
        'freetextColor',
        'make',
        'model',
        'isModelApproved',
        'modelGroup',
        'modelRaw',
        'description',
        'equipment',
        'modelYear',
        'regNo',
        'regDate',
        'regNoHidden',
        'hasImage',
        'isNew',
        'images',
        'warrantyProgram',
        'inWarrantyProgram',
        'price',
        'milage',
        'dealer',
        'accountManager',
        'carfaxReport',
        'additionalVehicleData',
        'beds',
        'length',
        'engineSize',
        'enginetype',
        'engineHours',
        'cargoLength',
        'cargoHeight',
        'cargoWidth',
        'totalWeight',
    ];

    private $car;

    public function __construct($car)
    {
        $this->car = $car;
    }

    public function syncCarToPost($alwaysUpdate = false)
    {
        $metaKeys = $this->metaKeys;

        $content = array_filter($this->car, function ($carKey) use ($metaKeys) {
            return in_array($carKey, $metaKeys);
        }, ARRAY_FILTER_USE_KEY);

        $content['usedState'] = $content['isNew'] ? 'new' : 'old';
        $content['currentPrice'] = $content['price']['value'];
        $content['city'] = '';
        $content['dealerName'] = '';

        if (isset($content['dealer']['name']) && !empty($content['dealer']['name'])) {
            $content['dealerName'] = $content['dealer']['name'];
        }

        if (isset($content['dealer']['address']['city'])) {
            $lowerCaseCity = mb_strtolower($content['dealer']['address']['city'], 'UTF-8');
            $fc = mb_strtoupper(mb_substr($lowerCaseCity, 0, 1));
            $content['city'] = $fc . mb_substr($lowerCaseCity, 1);
        }

        if (isset($content['images']) && !empty($content['images'])) {
            $content['thumbnailUrl'] = $content['images'][0]['imageFormats'][0]['url'];
        }

        if (!empty($content['freetextColor'])) {
            $content['color'] = $content['freetextColor'];
        }

        if (!empty($content['additionalVehicleData'])) {
            $vehicle_color = $content['additionalVehicleData']['color'];
            if (isset($vehicle_color) && $vehicle_color != 'Okänd' && empty($content['color'])) {
                $content['color'] = $vehicle_color;
            }

            $vehicle_color_group = $content['additionalVehicleData']['colorGroup'];
            if (isset($vehicle_color_group) && !in_array($vehicle_color_group, ['', 'okänd', false, null])) {
                $content['colorGroup'] = ucfirst($vehicle_color_group);
            }
            $vehicle_fwd = $content['additionalVehicleData']['fourWheelDrive'];
            if (isset($vehicle_fwd) && $vehicle_fwd !== '') {
                $content['fourWheelDrive'] = true;
            }
        }
        $content['leasing'] = !empty($content['price']['isLeasing']) ? '1' : '0';
        $content['vehicleType'] = strtolower($content['vehicleType']);

        // Check if the word 'dragkrok' exist in one of the equimpent items.
        // If so, set the $content['towBar'] to true
        if (!empty($content['equipment'])) {
            foreach ($content['equipment'] as $value) {
                if (strpos(strtolower($value), self::$towbarSearchWord) !== false) {
                    $content['towBar'] = true;
                    break;
                }
            }
        }

        $content = $this->itterateContent($content);
        $jsonString = json_encode($content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
        $encoded = preg_replace("/\\\\n/", "<br/>", $jsonString);
        $encoded = str_replace("[DUBBLEQUOTE]", '\"', $encoded);
        $encoded = str_replace("[SINGLEQUOTE]", "'", $encoded);
        $encoded = addslashes($encoded);

        $postData = [
            'post_title' => $this->car['name'],
            'post_type' => self::$postType,
            'post_status' => 'publish',
            'post_content' => $encoded,
            'post_date' => $this->getFormattedDate(),
        ];

        $this->postId = $this->checkIfCarExists();

        if (
            !$alwaysUpdate &&
            $this->postId &&
            $this->car['changedDate'] === get_post_meta($this->postId, 'changed_date', true)
        ) {
            return;
        }

        if (!$this->postId) {
            $this->postId = wp_insert_post($postData);
        } else {
            $postData['ID'] = $this->postId;
            wp_update_post($postData);
        }

        $this->addPostMeta();
    }

    private function checkIfCarExists()
    {
        $car = get_posts([
            'post_type' => self::$postType,
            'numberposts' => 1,
            'fields' => 'ids',
            'meta_key' => self::$keyExternalId,
            'meta_value' => $this->car['id'],
        ]);

        return $car ? $car[0] : false;
    }

    private function addPostMeta()
    {
        update_post_meta($this->postId, self::$keyExternalId, $this->car['id']);
        update_post_meta($this->postId, 'published_date', $this->car['publishedDate']);
        update_post_meta($this->postId, 'changed_date', $this->car['changedDate']);
    }


    private function itterateContent($array)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if ($key === "equipment") {
                    $equipmentValues = [];
                    foreach ($value as $equipment) {
                        $equipmentValues[] = $this->quoteReplace($equipment);
                    }
                    $array[$key] =  $equipmentValues;
                }
            }
            if (!is_array($value)) {
                $value = $this->quoteReplace($value);
                $array[$key] = $value;
            }
        }
        return $array;
    }

    private function quoteReplace($value)
    {
        if (is_string($value)) {
            $value = str_replace("'", "[SINGLEQUOTE]", $value);
            $value = str_replace('"', "[DUBBLEQUOTE]", $value);
            $value = addslashes($value);
        }
        return $value;
    }

    private function getFormattedDate()
    {
        $gmt = new \DateTimeZone('GMT');
        $date_obj = new \DateTime($this->car['changedDate'], $gmt);
        $date_obj->setTimezone(new \DateTimeZone('Europe/Stockholm'));

        return $date_obj->format('Y-m-d H:i:s');
    }
}
