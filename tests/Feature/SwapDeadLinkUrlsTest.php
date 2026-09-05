<?php

namespace Tests\Feature;

use App\Link;
use App\Ruin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SwapDeadLinkUrlsTest extends TestCase
{
    use RefreshDatabase;

    public function test_dead_urls_are_swapped_for_verified_replacements(): void
    {
        $ruin = Ruin::factory()->create();

        $migration = require database_path('migrations/2026_09_06_000000_swap_dead_link_urls.php');
        $swaps = $migration::URL_SWAPS;

        $this->assertCount(34, $swaps);

        // Every mapped entry swaps, even stored as a www variant.
        foreach ($swaps as $normalizedOld => $new) {
            Link::factory()->create(['ruin_id' => $ruin->id, 'url' => 'http://www.' . $normalizedOld]);
        }

        // Real-world stored forms: fragments, missing scheme, case, trailing slash, https.
        $variants = [
            'https://archaeologynewsnetwork.blogspot.co.uk/2014/08/ancient-city-of-metropolis-opens-to.html#a4tamTg00fqV2sGq.97' => 'https://www.hurriyetdailynews.com/city-of-mother-goddess-opens-to-tourism--70668',
            'http://bilgihanem.com/ani-harabeleri-hakkinda-bilgiler/#Ani_Harabeleri8217nin_Mimarisi' => 'https://muze.gov.tr/muze-detay?DistId=MRK&SectionId=ANI01',
            'www.osmaniyetso.org.tr/karatepe-aslantas-acik-hava-muzesi.html' => 'https://osmaniye.ktb.gov.tr/TR-161049/karatepe---aslantas-acik-hava-muzesi.html',
            'http://www.vize.bel.tr/Yz-56-Vize-Gezi-Rehberi.html' => 'https://vize.bel.tr/sayfa/turizm',
            'https://bathonea.org/eng/eng-index.html' => 'https://www.bathonea.org/',
            'http://arsizsanat.com/selge-antik-kenti-ve-adam-kayalar/' => 'https://arsizsanat.com.tr/selge-antik-kenti-ve-adam-kayalar/',
        ];

        foreach ($variants as $old => $new) {
            Link::factory()->create(['ruin_id' => $ruin->id, 'url' => $old]);
        }

        // Already-new, unrelated, punycode-stable and
        // same-path-different-query links must be left untouched.
        $untouched = [
            'https://www.salom.com.tr/arsiv/haber/88615/bir-ask-efsanesinden-dogan-sehir-stratonikeia-',
            'https://www.britannica.com/place/Assus',
            'https://www.xn--gzelaml-xxa9pru.com/guzelcamli/panionion.html',
            'http://rota360.net/dogarotalari.asp?id=22',
        ];

        foreach ($untouched as $url) {
            Link::factory()->create(['ruin_id' => $ruin->id, 'url' => $url]);
        }

        $migration->up();

        foreach ($swaps as $new) {
            $this->assertTrue(
                Link::where('url', $new)->exists(),
                "Expected swapped URL to exist: {$new}"
            );
        }

        foreach ($variants as $new) {
            $this->assertTrue(
                Link::where('url', $new)->exists(),
                "Expected variant-swapped URL to exist: {$new}"
            );
        }

        foreach ($untouched as $url) {
            $this->assertTrue(
                Link::where('url', $url)->exists(),
                "Expected untouched URL to survive: {$url}"
            );
        }

        // 34 www-variants + 6 real-world variants swapped + 2 already-good links.
        $this->assertSame(34 + 6 + 2, Link::whereIn('url', array_merge(array_values($swaps), array_values($variants)))->count());
    }
}
