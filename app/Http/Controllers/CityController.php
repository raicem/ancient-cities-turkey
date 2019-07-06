<?php

namespace App\Http\Controllers;

use App\City;
use App\Ruin;
use Illuminate\Support\Facades\App;

class CityController extends Controller
{
    public function __invoke(string $locale, string $city)
    {
        $this->setLocale($locale);

        $city = City::where(['slug' => $city])->first();

        $ruins = $city->ruins;

        if ($ruins->count() === 0) {
            abort(404);
        }

        $ruins = $this->translate($ruins, $locale);

        return view('city.index', [
            'city' => $city,
            'ruins' => $ruins,
        ]);
    }

    private function translate($ruins, string $locale = 'tr')
    {
        if ($locale === 'tr') {
            $ruins = $ruins->map(function (Ruin $ruin) {
                return $ruin->asTurkish();
            });

            return $ruins;
        }

        $ruins = $ruins->map(function (Ruin $ruin) {
            return $ruin->asEnglish();
        });

        return $ruins;
    }

    private function setLocale(string $locale): void
    {
        App::setLocale($locale);
    }
}
