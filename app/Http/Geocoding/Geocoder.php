<?php

namespace App\Http\Geocoding;

class Geocoder
{
    protected $accessToken;
    protected $response;

    public function __construct($token)
    {
        $this->accessToken = $token;
    }

    public function resolve($coordinates)
    {
        $curl = curl_init();
        $url = 'https://api.mapbox.com/geocoding/v5/mapbox.places/' . $coordinates . '.json?access_token=' . $this->accessToken;
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, $url);
        $response = curl_exec($curl);

        $this->setResponse(json_decode($response, true));
    }

    public function setResponse($response)
    {
        dd($response);
    }
}
