<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Curated spike 4 (2026-09-24): second vet-and-fill wave for 15
     * ruins (antiphellus → catalhoyuk). 58 fill URLs, all fetch-verified
     * alive and on-topic except two snippet-verified inclusions
     * (milliyet Asklepion story, beta.kulturportali Aşağı Pınar planner)
     * which links:check will confirm or flag for the next pass.
     *
     * VET deletes: dead domains (assosrehberim, gezimanya GeziNotlari
     * ×2), frozen archive.org snapshots, wrong-site YouTube, generic
     * not-about-site pages (lake article, god article, tag archive).
     * Baseline Wikipedia/Tripadvisor links are kept everywhere.
     *
     * @var list<array{slug: string, description: string, url: string, language: string}>
     */
    public const CURATED_LINKS = [
        ['slug' => 'antiphellus', 'description' => 'Ancient Route', 'url' => 'https://ancientroutesturkiye.com/en/antiphellus', 'language' => 'en'],
        ['slug' => 'antiphellus', 'description' => 'Turkey Homes', 'url' => 'https://www.turkeyhomes.com/blog/post/views-from-antiphellos-theater-in-kas', 'language' => 'en'],
        ['slug' => 'antiphellus', 'description' => 'Turizm Ansiklopedisi', 'url' => 'http://turkiyeturizmansiklopedisi.com/antiphellos-antik-kenti', 'language' => 'tr'],
        ['slug' => 'antiphellus', 'description' => 'Villahanem', 'url' => 'https://www.villahanem.com/blog/antiphellos-antik-tiyatro', 'language' => 'tr'],
        ['slug' => 'antiphellus', 'description' => 'kulturportali.gov.tr', 'url' => 'https://www.kulturportali.gov.tr/turkiye/antalya/gezilecekyer/antiphellos', 'language' => 'tr'],
        ['slug' => 'apollo-smintheion', 'description' => 'Ancient Route', 'url' => 'https://ancientroutesturkiye.com/en/temple-of-apollo-smintheus', 'language' => 'en'],
        ['slug' => 'apollo-smintheion', 'description' => 'Turkish Travels', 'url' => 'https://turkish-travels.com/2019/10/07/apollo-smintheion/', 'language' => 'en'],
        ['slug' => 'apollo-smintheion', 'description' => 'Yollardan', 'url' => 'https://www.yollardan.com/apollon-smintheus-kutsal-alani-ve-tapinagi/', 'language' => 'tr'],
        ['slug' => 'apollo-smintheion', 'description' => 'Anzac Hotels', 'url' => 'https://www.anzachotels.com/apollon-smintheus-tarihi-alani/?lang=tr', 'language' => 'tr'],
        ['slug' => 'apollonia', 'description' => 'Lycian Monuments', 'url' => 'https://www.lycianmonuments.com/apollonia/', 'language' => 'en'],
        ['slug' => 'apollonia', 'description' => 'Lycian Way', 'url' => 'https://lycianway.co.uk/culture/apollonia', 'language' => 'en'],
        ['slug' => 'apollonia', 'description' => 'Turizm Ansiklopedisi', 'url' => 'http://turkiyeturizmansiklopedisi.com/apollonia-antik-kenti', 'language' => 'tr'],
        ['slug' => 'apollonia', 'description' => 'Kaş Rehber', 'url' => 'https://www.kasrehber.com/haberler/apollonia-antik-kenti/', 'language' => 'tr'],
        ['slug' => 'asagi-pinar-mound', 'description' => 'Kırklareli Projesi', 'url' => 'https://kirklareliprojesi.org/asagipinar/', 'language' => 'tr'],
        ['slug' => 'asagi-pinar-mound', 'description' => 'Trakya Gezi', 'url' => 'https://www.trakyagezi.com/asagi-pinar-avrupa-yolunda-ilk-ayak-izleri/', 'language' => 'tr'],
        ['slug' => 'asagi-pinar-mound', 'description' => 'WhichMuseum', 'url' => 'https://whichmuseum.com/museum/asagi-pinar-open-air-museum-pinar-mahallesi-25226', 'language' => 'en'],
        ['slug' => 'asagi-pinar-mound', 'description' => 'kulturportali.gov.tr', 'url' => 'https://beta.kulturportali.gov.tr/turkiye/kirklareli/gezilecekyer/kirklarelinin-tarih-oncesi-kulturleri-asagipinar-ve-kanligecit-kazilari146780', 'language' => 'tr'],
        ['slug' => 'asklepion', 'description' => 'Biblical Archaeology', 'url' => 'https://library.biblicalarchaeology.org/sidebar/the-great-pergamum-asklepion/', 'language' => 'en'],
        ['slug' => 'asklepion', 'description' => 'Madain Project', 'url' => 'https://www.madainproject.com/asclepieion_at_pergamon', 'language' => 'en'],
        ['slug' => 'asklepion', 'description' => 'Milliyet', 'url' => 'https://www.milliyet.com.tr/arkeoloji/bergama-asklepionu-antik-dunyanin-saglik-kenti-7331589', 'language' => 'tr'],
        ['slug' => 'asklepion', 'description' => 'Via Hygeia', 'url' => 'https://via-hygeia.art/tr/blog/asklepion-sifa-merkezi-bergama/', 'language' => 'tr'],
        ['slug' => 'aslankaya', 'description' => 'Phrygian Monuments', 'url' => 'https://www.phrygianmonuments.com/aslankaya/', 'language' => 'en'],
        ['slug' => 'aslankaya', 'description' => 'Ancient Route', 'url' => 'https://ancientroutesturkiye.com/en/aslankaya', 'language' => 'en'],
        ['slug' => 'aslankaya', 'description' => 'Neresi Gezilir', 'url' => 'https://neresigezilir.com.tr/turkiye/afyonkarahisar/aslankaya-tapinagi', 'language' => 'tr'],
        ['slug' => 'aslankaya', 'description' => 'kulturportali.gov.tr', 'url' => 'https://www.kulturportali.gov.tr/turkiye/afyonkarahisar/gezilecekyer/doger-aslankaya-tapinagi', 'language' => 'tr'],
        ['slug' => 'aya-thecla', 'description' => 'ArchaeoTravel', 'url' => 'https://archaeotravel.eu/in-the-underground-cave-church-of-aya-tekla-in-silifke/', 'language' => 'en'],
        ['slug' => 'aya-thecla', 'description' => 'Turkey Travel Planner', 'url' => 'https://turkeytravelplanner.com/go/med/Silifke/ayatekla.html', 'language' => 'en'],
        ['slug' => 'aya-thecla', 'description' => 'Yolda Olmak', 'url' => 'https://yoldaolmak.com/aya-tekla-kilisesi', 'language' => 'tr'],
        ['slug' => 'aya-thecla', 'description' => "Bi' Gün Yine Yoldayız", 'url' => 'https://bigunyineyoldayiz.com/silifke-gezi-rehberi/', 'language' => 'tr'],
        ['slug' => 'ayazini', 'description' => 'Alaturka', 'url' => 'https://www.alaturka.info/en/turkey-country/aegean/3377-the-lion-and-the-snake-stone-in-phrygian-valley', 'language' => 'en'],
        ['slug' => 'ayazini', 'description' => 'Türkiye Routes', 'url' => 'https://www.turkiyeroutes.com/historical/ayazini-metropolis', 'language' => 'en'],
        ['slug' => 'ayazini', 'description' => 'Küçük Dünya', 'url' => 'https://kucukdunya.com/frig-vadisi-gezi-rehberi/', 'language' => 'tr'],
        ['slug' => 'balbura', 'description' => 'Lycian Monuments', 'url' => 'https://www.lycianmonuments.com/balboura/', 'language' => 'en'],
        ['slug' => 'balbura', 'description' => 'Likya Anıtları', 'url' => 'https://www.lycianmonuments.com/tr/balboura/', 'language' => 'tr'],
        ['slug' => 'bathonea', 'description' => 'Anatolian Archaeology', 'url' => 'https://www.anatolianarchaeology.net/bathonea-excavations-reveal-olive-oil-and-wine-workshop-near-kucukcekmece-lake/', 'language' => 'en'],
        ['slug' => 'bathonea', 'description' => 'KÜRE Ansiklopedi', 'url' => 'https://kureansiklopedi.com/en/detay/ancient-city-of-bathonea-254e8', 'language' => 'en'],
        ['slug' => 'bathonea', 'description' => 'Arkeofili', 'url' => 'https://arkeofili.com/istanbulda-bathonea-antik-kenti-calismalari-suruyor/', 'language' => 'tr'],
        ['slug' => 'bathonea', 'description' => 'Turizm Ansiklopedisi', 'url' => 'https://turkiyeturizmansiklopedisi.com/bathonea', 'language' => 'tr'],
        ['slug' => 'bayrakli-mound', 'description' => 'Ancient Route', 'url' => 'https://ancientroutesturkiye.com/en/bayrakli-mound', 'language' => 'en'],
        ['slug' => 'bayrakli-mound', 'description' => 'Visit İzmir', 'url' => 'https://www.visitizmir.org/en/Destinasyon/11193', 'language' => 'en'],
        ['slug' => 'bayrakli-mound', 'description' => 'Turizm Ansiklopedisi', 'url' => 'https://turkiyeturizmansiklopedisi.com/bayrakli-kazisi', 'language' => 'tr'],
        ['slug' => 'bayrakli-mound', 'description' => 'Küçük Dünya', 'url' => 'https://kucukdunya.com/smyrna-antik-kenti-izmirin-antik-yerlesimi/', 'language' => 'tr'],
        ['slug' => 'bayrakli-mound', 'description' => 'kulturportali.gov.tr', 'url' => 'https://kulturportali.gov.tr/turkiye/izmir/gezilecekyer/bayrakli-tepekule-smyrna', 'language' => 'tr'],
        ['slug' => 'blaundos', 'description' => 'Hürriyet Daily News', 'url' => 'https://www.hurriyetdailynews.com/excavation-season-begins-at-blaundos-ancient-city-210285', 'language' => 'en'],
        ['slug' => 'blaundos', 'description' => 'Daily Sabah', 'url' => 'https://www.dailysabah.com/life/travel/the-ancient-city-of-blaundus-anatolias-stonehenge', 'language' => 'en'],
        ['slug' => 'blaundos', 'description' => 'Turizm Ansiklopedisi', 'url' => 'https://turkiyeturizmansiklopedisi.com/blaundos-antik-kenti', 'language' => 'tr'],
        ['slug' => 'bubon', 'description' => 'New York Times', 'url' => 'https://www.nytimes.com/2023/10/30/arts/ancient-rome-bronzes-bubon.html', 'language' => 'en'],
        ['slug' => 'bubon', 'description' => 'Ancient Route', 'url' => 'https://ancientroutesturkiye.com/en/bubon', 'language' => 'en'],
        ['slug' => 'bubon', 'description' => 'Turizm Ansiklopedisi', 'url' => 'https://turkiyeturizmansiklopedisi.com/boubon-antik-kenti', 'language' => 'tr'],
        ['slug' => 'bubon', 'description' => 'Antik Rota', 'url' => 'https://ancientroutesturkiye.com/tr/bubon', 'language' => 'tr'],
        ['slug' => 'bubon', 'description' => 'kulturportali.gov.tr', 'url' => 'https://kulturportali.gov.tr/turkiye/burdur/gezilecekyer/boubon', 'language' => 'tr'],
        ['slug' => 'castabala', 'description' => 'Turkish Archaeological News', 'url' => 'https://turkisharchaeonews.net/site/castabala-hierapolis', 'language' => 'en'],
        ['slug' => 'castabala', 'description' => 'Art of Wayfaring', 'url' => 'https://artofwayfaring.com/2020/03/26/ancient-city-and-castle-of-kastabala/', 'language' => 'en'],
        ['slug' => 'castabala', 'description' => 'Antik Rota', 'url' => 'https://ancientroutesturkiye.com/tr/kastabala', 'language' => 'tr'],
        ['slug' => 'castabala', 'description' => 'Rota Senin', 'url' => 'https://www.rotasenin.com/kastabala-antik-kenti', 'language' => 'tr'],
        ['slug' => 'catalhoyuk', 'description' => 'Ancient Route', 'url' => 'https://ancientroutesturkiye.com/en/catalhoyuk', 'language' => 'en'],
        ['slug' => 'catalhoyuk', 'description' => 'Atlas Obscura', 'url' => 'https://www.atlasobscura.com/places/catalhoyuk', 'language' => 'en'],
        ['slug' => 'catalhoyuk', 'description' => 'Antik Rota', 'url' => 'https://ancientroutesturkiye.com/tr/catalhoyuk', 'language' => 'tr'],
    ];

    /**
     * @var list<array{slug: string, url: string}>
     */
    public const VET_DELETES = [
        ['slug' => 'apollo-smintheion', 'url' => 'http://www.assosrehberim.com/nm-Apollon_Smintheus-cp-117'],
        ['slug' => 'asagi-pinar-mound', 'url' => 'https://web.archive.org/web/20180722104931/http://arkeolojihaber.net/tag/asagi-pinar-hoyugu'],
        ['slug' => 'asklepion', 'url' => 'https://tr.wikipedia.org/wiki/Asklepios'],
        ['slug' => 'aslankaya', 'url' => 'https://gezimanya.com/GeziNotlari/frig-vadisi-4-bolum-aslankaya-yilankaya'],
        ['slug' => 'ayazini', 'url' => 'https://gezimanya.com/GeziNotlari/frig-vadisi-5-bolum-ayazini-oyma-kilise'],
        ['slug' => 'balbura', 'url' => 'https://www.youtube.com/watch?v=DG8AGpOOqOk'],
        ['slug' => 'bathonea', 'url' => 'https://en.wikipedia.org/wiki/Lake_Küçükçekmece#Archaeological_site'],
        ['slug' => 'bathonea', 'url' => 'https://web.archive.org/web/20180708162238/http://arkeolojihaber.net/tag/bathonea-antik-kenti/'],
        ['slug' => 'bathonea', 'url' => 'http://bathonea.org'],
        ['slug' => 'bubon', 'url' => 'http://tarihinizinde.com/etiket/calinan-kalintilar/'],
    ];

    /**
     * Optional 'language' key fixes mistagged link languages.
     *
     * @var list<array{slug: string, url: string, description?: string, language?: string}>
     */
    public const VET_RELABELS = [
        ['slug' => 'antiphellus', 'url' => 'https://romeartlover.it/Antifello.html', 'description' => 'romeartlover.it'],
        ['slug' => 'asagi-pinar-mound', 'url' => 'https://aktuelarkeoloji.com.tr/kategori/arkeoloji/8-bin-yillik-asagi-pinar-koyu-yeniden-canlaniyor', 'description' => 'aktuelarkeoloji.com.tr'],
        ['slug' => 'bayrakli-mound', 'url' => 'https://www.thoughtco.com/old-smyrna-turkey-greek-site-172034', 'description' => 'thoughtco.com', 'language' => 'en'],
    ];

    public function up(): void
    {
        foreach (self::VET_DELETES as $delete) {
            $ruinId = DB::table('ruins')->where('slug', $delete['slug'])->value('id');

            if ($ruinId === null) {
                continue;
            }

            DB::table('links')->where('ruin_id', $ruinId)->where('url', $delete['url'])->delete();
        }

        foreach (self::VET_RELABELS as $relabel) {
            $ruinId = DB::table('ruins')->where('slug', $relabel['slug'])->value('id');

            if ($ruinId === null) {
                continue;
            }

            $update = [];

            if (isset($relabel['description'])) {
                $update['description'] = $relabel['description'];
            }

            if (isset($relabel['language'])) {
                $update['language'] = $relabel['language'];
            }

            if ($update === []) {
                continue;
            }

            DB::table('links')
                ->where('ruin_id', $ruinId)
                ->where('url', $relabel['url'])
                ->update($update);
        }

        foreach (self::CURATED_LINKS as $link) {
            $ruinId = DB::table('ruins')->where('slug', $link['slug'])->value('id');

            if ($ruinId === null) {
                continue;
            }

            $alreadyLinked = DB::table('links')
                ->where('ruin_id', $ruinId)
                ->where('url', $link['url'])
                ->exists();

            if ($alreadyLinked) {
                continue;
            }

            DB::table('links')->insert([
                'ruin_id' => $ruinId,
                'description' => $link['description'],
                'url' => $link['url'],
                'language' => $link['language'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        foreach (self::CURATED_LINKS as $link) {
            DB::table('links')->where('url', $link['url'])->delete();
        }

        // Vetted-away links are intentionally not restored.
    }
};
