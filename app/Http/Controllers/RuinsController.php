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
        $geocoder = new \App\Http\Geocoding\Geocoder('pk.eyJ1IjoicmFpY2VtIiwiYSI6ImNqMjZmaHl6aTAwMmYzM3BqeWVrYnVjODIifQ.iZRVG8IE35SdbbkMhnK9ow');

        $ruin = Ruin::find(1);
        $lat = $ruin->latitude;
        $lng = $ruin->longitude;
        $coordinates = $lng . ',' . $lat;

        $result = $geocoder->resolve($coordinates);

        return $result;
    }
}
