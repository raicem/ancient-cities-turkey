<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Curated spike 5 (2026-09-25): third vet-and-fill wave for 15
     * ruins (claros → hasankeyf). 60 fill URLs, all fetch-verified
     * alive and on-topic.
     *
     * VET deletes: checker-confirmed dead domains (lycianturkey.com ×6,
     * anadolucografyasi.com, arkeolojidunyasi.com), hijacked gobeklitepe
     * domain (WoW spam), privatized blog, frozen archive.org snapshots,
     * dead soft-404s, and generic not-about-site pages. Baseline
     * Wikipedia/Tripadvisor links are kept everywhere.
     *
     * @var list<array{slug: string, description: string, url: string, language: string}>
     */
    public const CURATED_LINKS = [
        ['slug' => 'claros', 'description' => 'Ancient Route', 'url' => 'https://ancientroutesturkiye.com/en/claros', 'language' => 'en'],
        ['slug' => 'claros', 'description' => 'Alaturka', 'url' => 'https://www.alaturka.info/en/turkey-country/aegean/5491-klaros-ancient-oracle-site-near-selcuk', 'language' => 'en'],
        ['slug' => 'claros', 'description' => 'Gazete Duvar', 'url' => 'https://www.gazeteduvar.com.tr/kultur-sanat/2018/11/03/klaros-randevusuz-tanrilara-basvuramazsiniz/', 'language' => 'tr'],
        ['slug' => 'claros', 'description' => 'Küçük Dünya', 'url' => 'https://kucukdunya.com/claros-tanri-apollonun-kehanet-merkezi', 'language' => 'tr'],
        ['slug' => 'cyaneae', 'description' => 'Lycian Monuments', 'url' => 'https://www.lycianmonuments.com/kyaneai', 'language' => 'en'],
        ['slug' => 'cyaneae', 'description' => 'My Free Range Family', 'url' => 'https://www.myfreerangefamily.com/things-to-do-kas', 'language' => 'en'],
        ['slug' => 'cyaneae', 'description' => 'Turizm Ansiklopedisi', 'url' => 'https://turkiyeturizmansiklopedisi.com/kyaneai-antik-kenti', 'language' => 'tr'],
        ['slug' => 'cyaneae', 'description' => "Etstur Let's Go", 'url' => 'https://www.etstur.com/letsgo/demre-gezilecek-yerler/', 'language' => 'tr'],
        ['slug' => 'cyaneae', 'description' => 'kulturportali.gov.tr', 'url' => 'https://www.kulturportali.gov.tr/turkiye/antalya/gezilecekyer/kyaenai', 'language' => 'tr'],
        ['slug' => 'cyzicus', 'description' => 'Following Hadrian', 'url' => 'https://followinghadrianphotography.com/2024/02/25/cyzicus', 'language' => 'en'],
        ['slug' => 'cyzicus', 'description' => 'Travel Tour Shop', 'url' => 'https://traveltourshop.com/blog/kyzikos-ancient-city-travel-guide', 'language' => 'en'],
        ['slug' => 'cyzicus', 'description' => 'Turizm Ansiklopedisi', 'url' => 'https://turkiyeturizmansiklopedisi.com/kyzikos-antik-kenti', 'language' => 'tr'],
        ['slug' => 'cyzicus', 'description' => 'Doğayı Dinle', 'url' => 'https://www.dogayidinle.com/turizm-ve-kultur/erdek-kyzikos-antik-kenti-tarih-ve-ziyaret-onerileri/2088', 'language' => 'tr'],
        ['slug' => 'cyzicus', 'description' => 'erdek.bel.tr', 'url' => 'https://www.erdek.bel.tr/kyzikos-antik-kenti', 'language' => 'tr'],
        ['slug' => 'dara', 'description' => 'War History Network', 'url' => 'https://warhistorynetwork.com/groups/medieval-military-history-c-500-c-1500/forum/topics/focus-on-tactics-byzantium-versus-persia-at-the-battle-of-dara', 'language' => 'en'],
        ['slug' => 'dara', 'description' => 'Arkeofili', 'url' => 'https://arkeofili.com/mardinde-ahir-olarak-kullanan-alan-1500-yillik-su-sarnici-cikti', 'language' => 'tr'],
        ['slug' => 'dara', 'description' => 'Museum of Wander', 'url' => 'https://museumofwander.com/dara-ancient-city', 'language' => 'en'],
        ['slug' => 'dara', 'description' => 'Küçük Dünya', 'url' => 'https://kucukdunya.com/dara-antik-kenti', 'language' => 'tr'],
        ['slug' => 'dara', 'description' => 'mardin.ktb.gov.tr', 'url' => 'https://mardin.ktb.gov.tr/TR-373256/dara-antik-kenti.html', 'language' => 'tr'],
        ['slug' => 'daskyleion', 'description' => 'World Archaeology', 'url' => 'https://www.world-archaeology.com/features/turkey-dascyleum', 'language' => 'en'],
        ['slug' => 'daskyleion', 'description' => 'Turizm Ansiklopedisi', 'url' => 'https://turkiyeturizmansiklopedisi.com/daskyleion-antik-kenti-kazi-calismalari', 'language' => 'tr'],
        ['slug' => 'daskyleion', 'description' => 'Daily Sabah', 'url' => 'https://www.dailysabah.com/arts/reliefs-from-5th-century-bc-found-in-western-turkeys-daskyleion/news', 'language' => 'en'],
        ['slug' => 'daskyleion', 'description' => 'Gezinomi', 'url' => 'https://www.gezinomi.com/gezi-rehberi/bandirma-da-mutlaka-gezilmesi-gereken-yerler.html', 'language' => 'tr'],
        ['slug' => 'daskyleion', 'description' => 'kulturportali.gov.tr', 'url' => 'https://www.kulturportali.gov.tr/turkiye/balikesir/gezilecekyer/daskyleion-antik-kenti', 'language' => 'tr'],
        ['slug' => 'didyma', 'description' => 'Livius', 'url' => 'https://www.livius.org/articles/place/didyma', 'language' => 'en'],
        ['slug' => 'didyma', 'description' => "Etstur Let's Go", 'url' => 'https://www.etstur.com/letsgo/apollon-tapinagi-hakkinda-merak-edilenler', 'language' => 'tr'],
        ['slug' => 'didyma', 'description' => 'Travel Thru History', 'url' => 'https://travelthruhistory.com/consulting-the-apollo-oracle', 'language' => 'en'],
        ['slug' => 'didyma', 'description' => 'Gezimanya', 'url' => 'https://gezimanya.com/didim/gezilecek-yerler/apollon-tapinagi-0', 'language' => 'tr'],
        ['slug' => 'erythrai', 'description' => 'Turkish Archaeological News', 'url' => 'http://turkisharchaeonews.net/site/erythrae', 'language' => 'en'],
        ['slug' => 'erythrai', 'description' => 'Arkeo Gezi', 'url' => 'https://arkeogezi.com/2014/06/29/erythrai-iyonyanin-kirmizi-yildizi/', 'language' => 'tr'],
        ['slug' => 'erythrai', 'description' => 'Kültür Envanteri', 'url' => 'https://kulturenvanteri.com/yer/erythrai/', 'language' => 'tr'],
        ['slug' => 'eumeneia', 'description' => 'Kültür Envanteri', 'url' => 'https://kulturenvanteri.com/yer/eumania/', 'language' => 'tr'],
        ['slug' => 'eumeneia', 'description' => 'Çivril Belediyesi', 'url' => 'https://www.civril.bel.tr/eumenia-isikli-antik-kenti', 'language' => 'tr'],
        ['slug' => 'euromos', 'description' => 'Livius', 'url' => 'https://www.livius.org/articles/place/euromos/', 'language' => 'en'],
        ['slug' => 'euromos', 'description' => 'Art of Wayfaring', 'url' => 'https://artofwayfaring.com/destinations/euromos-ancient-city', 'language' => 'en'],
        ['slug' => 'euromos', 'description' => 'Arkeofili', 'url' => 'https://arkeofili.com/euromos-antik-kenti/', 'language' => 'tr'],
        ['slug' => 'euromos', 'description' => 'Küçük Dünya', 'url' => 'https://kucukdunya.com/euromos-karyanin-guclu-kenti/', 'language' => 'tr'],
        ['slug' => 'gerga', 'description' => 'Carian Monuments', 'url' => 'https://www.carianmonuments.com/gerga/', 'language' => 'en'],
        ['slug' => 'gerga', 'description' => 'Ancient Route', 'url' => 'https://ancientroutesturkiye.com/en/gerga', 'language' => 'en'],
        ['slug' => 'gerga', 'description' => 'Yeni Kıroba', 'url' => 'https://www.yenikiroba.com/gerga-antik-kenti-gizemli-tarihi-anlami-ve-ulasim-rehberi', 'language' => 'tr'],
        ['slug' => 'gerga', 'description' => 'Küçük Dünya', 'url' => 'https://kucukdunya.com/gerga-antik-kenti-gizemli-yerlesim/', 'language' => 'tr'],
        ['slug' => 'gerga', 'description' => 'aydin.ktb.gov.tr', 'url' => 'https://aydin.ktb.gov.tr/TR-64422/gerga.html', 'language' => 'tr'],
        ['slug' => 'gobeklitepe', 'description' => 'Smithsonian', 'url' => 'https://www.smithsonianmag.com/history/gobekli-tepe-the-worlds-first-temple-83613665/', 'language' => 'en'],
        ['slug' => 'gobeklitepe', 'description' => 'Atlas Obscura', 'url' => 'https://www.atlasobscura.com/places/gobekli-tepe', 'language' => 'en'],
        ['slug' => 'gobeklitepe', 'description' => 'Arkeofili', 'url' => 'https://arkeofili.com/gobeklitepe-aslinda-ne-anlatiyor-kimler-neden-nasil-yapti/', 'language' => 'tr'],
        ['slug' => 'gobeklitepe', 'description' => "Etstur Let's Go", 'url' => 'https://www.etstur.com/letsgo/gobeklitepe-gezi-rehberi/', 'language' => 'tr'],
        ['slug' => 'goekceseki', 'description' => 'karaman.gov.tr', 'url' => 'https://www.karaman.gov.tr/gokceseki-oren-yeri', 'language' => 'tr'],
        ['slug' => 'goekceseki', 'description' => 'ODÖO', 'url' => 'https://okuldisiogrenme.eba.gov.tr/mekan-detay/gokceseki-orenyeri-9245', 'language' => 'tr'],
        ['slug' => 'gordium', 'description' => 'BBC Travel', 'url' => 'https://www.bbc.co.uk/travel/article/20240320-gordion-a-lost-city-of-legends-in-central-turkey', 'language' => 'en'],
        ['slug' => 'gordium', 'description' => 'Daily Sabah', 'url' => 'https://www.dailysabah.com/life/travel/ankara-travels-a-day-in-gordion-the-capital-of-ancient-phrygians', 'language' => 'en'],
        ['slug' => 'gordium', 'description' => 'GazeteBilkent', 'url' => 'https://gazetebilkent.com/tarih-2/455/bir-buyuk-iskender-efsanesi-gordion-dugumu', 'language' => 'tr'],
        ['slug' => 'gordium', 'description' => 'Küçük Dünya', 'url' => 'https://kucukdunya.com/gordion-antik-kenti-frigyanin-baskenti', 'language' => 'tr'],
        ['slug' => 'hadrianapolis', 'description' => 'Hürriyet Daily News', 'url' => 'https://www.hurriyetdailynews.com/hadrianoupolis-to-be-known-for-its-mosaics-170137', 'language' => 'en'],
        ['slug' => 'hadrianapolis', 'description' => 'KÜRE Ansiklopedi', 'url' => 'https://kureansiklopedi.com/en/detay/ancient-city-of-hadrianopolis-01f53', 'language' => 'en'],
        ['slug' => 'hadrianapolis', 'description' => 'Bmag', 'url' => 'https://bmag.com.tr/haber/karadeniz-mozaikleri-hadrianoupolis-karabuk', 'language' => 'tr'],
        ['slug' => 'hadrianapolis', 'description' => 'Küçük Dünya', 'url' => 'https://kucukdunya.com/hadrianopolis-antik-kenti', 'language' => 'tr'],
        ['slug' => 'hasankeyf', 'description' => 'DW', 'url' => 'https://www.dw.com/en/hasankeyf-the-town-that-drove-away/a-77031487', 'language' => 'en'],
        ['slug' => 'hasankeyf', 'description' => 'The Atlantic', 'url' => 'https://www.theatlantic.com/photo/2020/10/photos-an-ancient-town-submerged-hasankeyf-underwater/616562', 'language' => 'en'],
        ['slug' => 'hasankeyf', 'description' => 'Habertürk', 'url' => 'https://www.haberturk.com/hasankeyf-te-552-yillik-zeynel-bey-turbesi-turistlerin-ugrak-noktalarindan-3837248', 'language' => 'tr'],
        ['slug' => 'hasankeyf', 'description' => 'Travel Walk Tours', 'url' => 'https://travelwalktours.com/tr/blog/batman-gezilecek-yerler-hasankeyf-rehberi', 'language' => 'tr'],
    ];

    /**
     * @var list<array{slug: string, url: string}>
     */
    public const VET_DELETES = [
        ['slug' => 'cyaneae', 'url' => 'http://www.lycianturkey.com/lycian_sites/cyaneae.htm'],
        ['slug' => 'erythrai', 'url' => 'https://tr.wikipedia.org/wiki/Ildır,_Çeşme'],
        ['slug' => 'erythrai', 'url' => 'http://www.yoldakiizler.com/2014/08/cesme-ildiri-erythrai-antik-kent.html'],
        ['slug' => 'eumeneia', 'url' => 'https://web.archive.org/web/20200129073534/http://www.pamukkale.gov.tr/tr/Antik-Kentler/Eumania-Antik-Kenti'],
        ['slug' => 'euromos', 'url' => 'http://www.didimmarket.com/tr/antikkent/euromos-antik-kenti.html'],
        ['slug' => 'gobeklitepe', 'url' => 'http://gobeklitepe.info'],
        ['slug' => 'goekceseki', 'url' => 'http://www.radikal.com.tr/karaman-haber/gokcesekinin-2-bin-yillik-lahitleri-gun-yuzune-cikariliyor-1335288/'],
        ['slug' => 'gordium', 'url' => 'https://gezgindiradimiz.wordpress.com/2016/08/12/gordion-muzesi-ve-kral-midas-tumulusu/'],
        ['slug' => 'hadrianapolis', 'url' => 'https://web.archive.org/web/20171102050704/http://arkeolojihaber.net/tag/hadrianapolis-antik-kenti'],
        ['slug' => 'letoon', 'url' => 'http://lycianturkey.com/lycian_sites/letoon.htm'],
        ['slug' => 'xanthos', 'url' => 'http://www.lycianturkey.com/lycian_sites/xanthos.htm'],
        ['slug' => 'patara', 'url' => 'http://www.lycianturkey.com/lycian_sites/patara.htm'],
        ['slug' => 'simena', 'url' => 'http://lycianturkey.com/lycian_sites/kekova_simena.htm'],
        ['slug' => 'arykanda', 'url' => 'http://www.lycianturkey.com/lycian_sites/arycanda.htm'],
        ['slug' => 'panionium', 'url' => 'http://www.anadolucografyasi.com/yazilar/antik-harabeler-arasindan-kesis-patikalarina-yurumek.html'],
        ['slug' => 'hyllarima', 'url' => 'http://www.arkeolojidunyasi.com/antik_kentler/hyllarima.html'],
    ];

    /**
     * @var list<array{slug: string, url: string, description: string}>
     */
    public const VET_RELABELS = [
        ['slug' => 'claros', 'url' => 'https://arkeogezi.com/2014/07/14/klaros-mantonun-gozyaslari/', 'description' => 'arkeogezi.com'],
        ['slug' => 'daskyleion', 'url' => 'http://www.balikesirkulturturizm.gov.tr/TR,90612/antik-kentler-oren-yerleri.html', 'description' => 'balikesirkulturturizm.gov.tr'],
        ['slug' => 'gordium', 'url' => 'https://deretepe.net.tr/gezi-hikayeleri/tarihe-bir-yolculuk-yassihoyuk-ve-gordion-gezisi/', 'description' => 'deretepe.net.tr'],
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

            DB::table('links')
                ->where('ruin_id', $ruinId)
                ->where('url', $relabel['url'])
                ->update(['description' => $relabel['description']]);
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
