<?php

namespace TF\AccessPackage;

class API
{
    protected $baseUrl = 'https://api.bytbil.com/vehicles/dealergroups';

    public function getFeed()
    {
        $url = sprintf(
            '%s/%s?token=%s',
            $this->baseUrl,
            get_option('access_package_json_file'),
            get_option('access_package_token')
        );
        $response = wp_remote_get($url, ['timeout' => 60]);

        if (wp_remote_retrieve_response_code($response) !== 200) {
            return false;
        }

        $body = wp_remote_retrieve_body($response);

        return json_decode($body, 1);
    }
}
