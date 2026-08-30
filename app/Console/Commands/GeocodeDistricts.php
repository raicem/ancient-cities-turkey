<?php

namespace App\Console\Commands;

use App\Ruin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GeocodeDistricts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:geocode-districts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Geocode districts (ilce) from the coordinates.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ruins = Ruin::whereNull('district')->get();

        if ($ruins->isEmpty()) {
            $this->info('Nothing to geocode.');

            return;
        }

        $saved = 0;

        foreach ($ruins as $ruin) {
            try {
                $district = $this->geocodeDistrict($ruin);
            } catch (\Exception $e) {
                $this->alert("Error occurred. But continuing. {$e->getMessage()}");

                continue;
            }

            if ($district === null) {
                $this->warn("No district found for {$ruin->name}. Skipped.");

                continue;
            }

            $ruin->district = $district;
            $ruin->save();

            $saved += 1;

            $this->info("{$ruin->name} is in {$district}. Saved.");
        }

        $this->info("{$saved} ruins geocoded.");
    }

    private function geocodeDistrict(Ruin $ruin): ?string
    {
        sleep(1);

        $response = Http::get('https://api.mapbox.com/geocoding/v5/mapbox.places/' . $ruin->longitude . ',' . $ruin->latitude . '.json', [
            'types' => 'place',
            'access_token' => config('services.mapbox.access_token'),
        ]);

        $features = $response->json('features');

        if (!is_array($features) || count($features) === 0) {
            return null;
        }

        return $features[0]['text'] ?? null;
    }
}
