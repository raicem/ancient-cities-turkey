<?php

namespace App\Console\Commands;

use App\City;
use App\Ruin;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GetCitiesFromCoordinates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-cities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Geocode cities from the coordinates.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $ruins = Ruin::where(['city_id' => null])->get();

        foreach ($ruins as $ruin) {
            try {
                $city = $this->geocodeCity($ruin);
            } catch (\Exception $e) {
                $this->alert("Error occurred. But continuing. {$e->getMessage()}");
                continue;
            }

            $ruin->city_id = $city->id;

            $ruin->save();

            $this->info("{$ruin->name} is in {$city->name}. Saved.");
        }
    }

    private function geocodeCity(Ruin $ruin): City
    {
        $accessToken = config('services.mapbox.access_token');

        $lat = $ruin->latitude;
        $lng = $ruin->longitude;
        $coordinates = $lng . ',' . $lat;

        $curl = curl_init();
        $url = 'https://api.mapbox.com/geocoding/v5/mapbox.places/' . $coordinates . '.json?access_token=' . $accessToken;
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, $url);
        sleep(1);
        $response = curl_exec($curl);

        $response = json_decode($response, true);

        $features = $response['features'];

        $region = array_filter($features, function (array $item) {
            return $item['place_type'][0] === 'region';
        });

        if (count($region) === 0) {
            throw new \RuntimeException('No region is found!');
        }

        $region = current($region);

        return $this->fetchCity(Str::slug($region['text']));
    }

    private function fetchCity(string $slug): City
    {
        $city = City::where('slug', $slug)->first();

        if (!$city) {
            throw new \RuntimeException("No city found: {$slug}");
        }

        return $city;
    }
}
