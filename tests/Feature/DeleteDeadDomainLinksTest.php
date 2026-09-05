<?php

namespace Tests\Feature;

use App\Link;
use App\Ruin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteDeadDomainLinksTest extends TestCase
{
    use RefreshDatabase;

    public function test_links_on_dead_domains_are_deleted(): void
    {
        $ruin = Ruin::factory()->create();

        $deadUrls = [
            'http://www.geziantalya.com/item/side-antik-kenti',
            'http://www.geziantalya.com/item/selge-antik-kenti',
            'http://sahindogan.com/efes-antik-kenti',
            'https://www.teosarkeoloji.com/index.php',
            'http://turcom.net/kyme/',
            'http://www.phaselis.org/en/',
            // Case and scheme-less variants must match too.
            'http://WWW.ARKEOPOLIS.COM/ainos-antik-kenti/',
            'www.pudra.com/yasam/gezi/izmir-torbali-nin-mabedi-metropolis-26556.htm',
            'http://www.sehirkacaklari.com/aksunun-tarih-kokan-antik-kenti-perge/',
        ];

        foreach ($deadUrls as $url) {
            Link::factory()->create(['ruin_id' => $ruin->id, 'url' => $url]);
        }

        $liveUrls = [
            // Lookalikes sharing a substring with a dead host must survive.
            'https://phaselisancientcity.com/',
            'http://myturcom.net/kyme/',
            // Successor hosts must survive.
            'https://teos.ankara.edu.tr/',
            'https://romeartlover.it/Sardi.html',
            // Unrelated healthy links must survive.
            'https://www.britannica.com/place/Assus',
            'https://eksisozluk.com/entry/7071969',
        ];

        foreach ($liveUrls as $url) {
            Link::factory()->create(['ruin_id' => $ruin->id, 'url' => $url]);
        }

        $migration = require database_path('migrations/2026_09_05_000000_delete_dead_domain_links.php');
        $migration->up();

        $this->assertSame([], Link::whereIn('url', $deadUrls)->pluck('url')->all());

        $this->assertEqualsCanonicalizing(
            $liveUrls,
            Link::whereIn('url', $liveUrls)->pluck('url')->all()
        );
    }
}
