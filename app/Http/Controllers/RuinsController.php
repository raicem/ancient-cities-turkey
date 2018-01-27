<?php

namespace App\Http\Controllers;

use App\Ruin;
use Illuminate\Support\Facades\App;

class RuinsController extends Controller
{
    public function sitemap()
    {
        return view('index', [
            'ruins' => Ruin::all()
        ]);
    }

    public function index($locale = 'tr')
    {
        App::setLocale($locale);

        return view('home');
    }

    public function testingGeolocation()
    {
        $curl = curl_init();
        $accessToken = 'pk.eyJ1IjoicmFpY2VtIiwiYSI6ImNqMjZmaHl6aTAwMmYzM3BqeWVrYnVjODIifQ.iZRVG8IE35SdbbkMhnK9ow';
        $url = 'https://api.mapbox.com/geocoding/v5/mapbox.places/Los%20Angeles.json?access_token=' . $accessToken;
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, $url);
        $response = curl_exec($curl);
        $json = json_decode($response, true);

        return response()->json($json);
    }
}
