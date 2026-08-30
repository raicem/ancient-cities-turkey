<?php

namespace Tests\Feature;

use App\Ruin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GeocodeDistrictsCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_geocodes_districts_for_ruins_missing_one()
    {
        Http::fake([
            'api.mapbox.com/*' => Http::response([
                'features' => [
                    ['text' => 'Datça'],
                ],
            ]),
        ]);

        $ruinWithoutDistrict = Ruin::factory()->create(['district' => null]);
        $ruinWithDistrict = Ruin::factory()->create(['district' => 'Existing']);

        $this->artisan('app:geocode-districts')->assertExitCode(0);

        $this->assertSame('Datça', $ruinWithoutDistrict->fresh()->district);
        $this->assertSame('Existing', $ruinWithDistrict->fresh()->district);
    }

    public function test_it_continues_when_geocoding_fails()
    {
        Http::fake([
            'api.mapbox.com/*' => Http::response(['features' => []]),
        ]);

        $ruin = Ruin::factory()->create(['district' => null]);

        $this->artisan('app:geocode-districts')->assertExitCode(0);

        $this->assertNull($ruin->fresh()->district);
    }
}
