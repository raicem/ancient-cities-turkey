<?php

namespace App\Http\Controllers\Api;

use App\Ruin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RuinsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */    
    public function index()
    {
        $geoJson = [
            'type'     => 'FeatureCollection',
            'features' => []
        ];

        foreach (Ruin::all() as $ruin) {
            $geoJson['features'][] = [
                'type' => 'Feature',
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [$ruin->longitude, $ruin->latitude]
                ],
                'properties' => [
                    'name_tr' => $ruin->name_tr,
                    'name_en' => $ruin->name,
                    'slug' => $ruin->slug
                ]
            ];
        }

        return $geoJson;
    }

    /**
     * Display the specified resource.
     *
     * @param Ruin $ruin
     * @return Ruin
     * @internal param int $id
     */
    public function show(Ruin $ruin)
    {
        return $ruin->asEnglish();
    }

    /**
     * Display the specified resource in Turkish.
     *
     * @param Ruin $ruin
     * @return Ruin
     * @internal param int $id
     */
    public function showTurkish(Ruin $ruin)
    {
        return $ruin->asTurkish();
    }
}
