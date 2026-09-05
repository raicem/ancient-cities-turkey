<?php

use App\Link;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * Dead URL => verified-alive replacement (each replacement checked
     * and returning HTTP 200 at its exact URL).
     *
     * Keys are normalized (no scheme, no www, lowercase, no trailing
     * slash, no fragment; the query string is kept so ?id=21 does not
     * match ?id=22). Stored URLs match loosely on purpose so http/https,
     * www, case, trailing-slash and fragment variants all resolve to the
     * same replacement.
     *
     * @var array<string, string>
     */
    public const URL_SWAPS = [
        'bathonea.org/eng/eng-index.html' => 'https://www.bathonea.org/',
        'troiavakfi.com/ancient-city-of-parion' => 'https://troiavakfi.com/harita/parion-biga/',
        'romeartlover.tripod.com/sardi.html' => 'https://romeartlover.it/Sardi.html',
        'romeartlover.tripod.com/antifello.html' => 'https://romeartlover.it/Antifello.html',
        'arkeogezi.blogspot.co.uk/2014/07/yanls-isimli-metropolis.html' => 'https://arkeogezi.com/2014/08/18/yanlis-isimli-metropolis/',
        'arkeogezi.blogspot.co.uk/2014/07/klaros-manto-gozyaslar.html' => 'https://arkeogezi.com/2014/07/14/klaros-mantonun-gozyaslari/',
        'arkeogezi.blogspot.com/2014/05/temnos-unutulan-bir-aiol-kenti.html' => 'https://arkeogezi.com/2014/05/25/temnos-unutulan-bir-aiol-kenti/',
        'gezimanya.com/gezinotlari/lykosdan-dogan-uygarlik-isigi-laodikeia' => 'https://gezimanya.com/GeziNotlari/lykostan-dogan-uygarlik-isigi-laodikeia-denizli',
        'salom.com.tr/haber-88615-bir_ask_efsanesinden_dogan_sehir__stratonikeia_.html' => 'https://www.salom.com.tr/arsiv/haber/88615/bir-ask-efsanesinden-dogan-sehir-stratonikeia-',
        'arsizsanat.com/selge-antik-kenti-ve-adam-kayalar' => 'https://arsizsanat.com.tr/selge-antik-kenti-ve-adam-kayalar/',
        'izmir.ktb.gov.tr/tr-77163/bayrakli-hoyugu-orenyeri-kazi-calismasi--izmir.html' => 'https://izmir.ktb.gov.tr/TR-77163/smyrna-bayrakli-hoyugu-kazisi--izmir.html',
        'edebiyatvesanatakademisi.com/forum/detay/antik-kentler/gerga-antik-kenti-aydin-cine-33888.aspx' => 'https://edebiyatvesanatakademisi.com/post/gerga-antik-kenti-aydin-cine/80401',
        'didim.bel.tr/sehir-d-81-filozoflarin-sehri-milet' => 'https://didim.bel.tr/sayfa/4138/filozoflarin-sehri-milet',
        'lagina.pau.edu.tr/index2.html' => 'https://www.pau.edu.tr/lagina',
        'stratonikeia.pau.edu.tr' => 'https://www.pau.edu.tr/stratonikeia',
        'olymposkazisi.com/indexe.html' => 'https://olymposkazisi.com/',
        'vize.bel.tr/yz-56-vize-gezi-rehberi.html' => 'https://vize.bel.tr/sayfa/turizm',
        'archaeologynewsnetwork.blogspot.co.uk/2014/08/ancient-city-of-metropolis-opens-to.html' => 'https://www.hurriyetdailynews.com/city-of-mother-goddess-opens-to-tourism--70668',
        'gezipgordum.com/midas-aniti' => 'https://eskisehir.ktb.gov.tr/TR-336950/yazilikaya-midas-aniti-daglik-frigya.html',
        'bgc.org.tr/ansiklopedi/iznik-surlari.html' => 'https://www.kulturportali.gov.tr/turkiye/bursa/gezilecekyer/znik-surlari',
        'neredekal.com/teion-billaos-antik-kenti' => 'https://muze.gov.tr/muze-detay?DistId=MRK&SectionId=FLO01',
        'bilgihanem.com/ani-harabeleri-hakkinda-bilgiler' => 'https://muze.gov.tr/muze-detay?DistId=MRK&SectionId=ANI01',
        'bilgihanem.com/anavarza-kalesi-hakkinda-bilgiler' => 'https://muze.gov.tr/muze-detay?SectionId=ADV01&DistId=MRK',
        'fullantalya.com/antik-cagin-guzel-kokular-diyari-phaselis' => 'https://muze.gov.tr/muze-detay?DistId=PHS&SectionId=PHS01',
        'dosim.gov.tr/muze/282' => 'https://kulturportali.gov.tr/turkiye/mugla/gezilecekyer/euromos',
        'osmaniyetso.org.tr/karatepe-aslantas-acik-hava-muzesi.html' => 'https://osmaniye.ktb.gov.tr/TR-161049/karatepe---aslantas-acik-hava-muzesi.html',
        'rota360.net/dogarotalari.asp?id=21' => 'http://rota360.com.tr/dogarotalari.asp?id=21',
        'deretepe.net/gezi-hikayeleri/tarihe-bir-yolculuk-yassihoyuk-ve-gordion-gezisi' => 'https://deretepe.net.tr/gezi-hikayeleri/tarihe-bir-yolculuk-yassihoyuk-ve-gordion-gezisi/',
        'ankusam.ankara.edu.tr/erythrai' => 'https://ankusam.ankara.edu.tr/erythrai/',
        'olymposkazisi.com' => 'https://olymposkazisi.com/',
        'edebiyatvesanatakademisi.com/forum/detay/antik-kentler/kirklareli-asagi-pinar-hoyugu-33913.aspx' => 'https://aktuelarkeoloji.com.tr/kategori/arkeoloji/8-bin-yillik-asagi-pinar-koyu-yeniden-canlaniyor',
        'visitizmir.org/tr/ilce/bergama/nasil-gelmeli/pergamon-antik-kenti' => 'https://muze.gov.tr/muze-detay?DistId=AKR&SectionId=AKR01',
        'visitizmir.org/tr/ilce/bornova/nasil-gelmeli/yesilova-hoeyuegue' => 'https://izmir.ktb.gov.tr/TR-77164/yesilova-hoyugu-kazi--bornova--izmir.html',
        'güzelçamlı.com/guzelcamli/panionion.html' => 'https://www.xn--gzelaml-xxa9pru.com/guzelcamli/panionion.html',
    ];

    public function up(): void
    {
        $map = self::URL_SWAPS;
        $swapped = [];
        $matched = [];

        Link::query()->chunkById(200, function ($links) use ($map, &$swapped, &$matched): void {
            foreach ($links as $link) {
                $key = self::normalizeUrl($link->url);

                if (isset($map[$key])) {
                    $old = $link->url;
                    $link->url = $map[$key];
                    $link->save();
                    $matched[$key] = true;
                    $swapped[] = $old . ' => ' . $map[$key];
                }
            }
        });

        if ($swapped !== []) {
            Log::info('Swapped dead link URLs', $swapped);
        }

        $missing = array_diff(array_keys($map), array_keys($matched));

        if ($missing !== []) {
            Log::warning('Link swap: expected old URLs not found in database', array_values($missing));
        }
    }

    public function down(): void
    {
        // Data-only cleanup, intentionally not reversible.
    }

    public static function normalizeUrl(string $url): string
    {
        if (! str_contains($url, '://')) {
            $url = 'http://' . $url;
        }

        $parts = parse_url($url);
        $host = strtolower((string) ($parts['host'] ?? ''));
        $host = (string) preg_replace('/^www\./', '', $host);
        $path = rtrim((string) ($parts['path'] ?? ''), '/');
        $query = isset($parts['query']) && $parts['query'] !== '' ? '?' . $parts['query'] : '';

        return strtolower($host . $path . $query);
    }
};
