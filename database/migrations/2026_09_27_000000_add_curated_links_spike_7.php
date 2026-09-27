<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Curated spike 7 (2026-09-27): fifth vet-and-fill wave for 15
     * ruins (kibyra → melid). 63 fill URLs, all fetch-verified alive
     * and on-topic.
     *
     * VET deletes: wrong-site mix-up (three Aya Tekla links on Mamure
     * Castle, ~100 km off), same-domain city-article dupes
     * (mausoleum), hijacked project domain, dead blogs, frozen
     * archive.org snapshots, and generic not-about-site pages.
     * Baseline Wikipedia/Tripadvisor links are kept everywhere.
     *
     * @var list<array{slug: string, description: string, url: string, language: string}>
     */
    public const CURATED_LINKS = [
        ['slug' => 'kibyra', 'description' => 'UNESCO', 'url' => 'https://whc.unesco.org/en/tentativelists/6123', 'language' => 'en'],
        ['slug' => 'kibyra', 'description' => 'Turkish Archaeological News', 'url' => 'https://turkisharchaeonews.net/site/kibyra', 'language' => 'en'],
        ['slug' => 'kibyra', 'description' => 'Turizm Ansiklopedisi', 'url' => 'https://turkiyeturizmansiklopedisi.com/kibyra-antik-kenti', 'language' => 'tr'],
        ['slug' => 'kibyra', 'description' => 'Anatolian Archaeology', 'url' => 'https://www.anatolianarchaeology.net/2000-year-old-medusa-mosaic-at-kibyra-reopens-to-visitors-in-turkiye', 'language' => 'en'],
        ['slug' => 'kibyra', 'description' => 'Burdur Gazetesi', 'url' => 'https://www.burdurgazetesi.com/haber/19915454/burdurun-antik-kenti-kibyrada-medusa-mozaigi-2024-turizm-sezonuna-acildi', 'language' => 'tr'],
        ['slug' => 'kibyra', 'description' => 'kulturportali.gov.tr', 'url' => 'https://www.kulturportali.gov.tr/turkiye/burdur/gezilecekyer/kibyra-antik-kenti', 'language' => 'tr'],
        ['slug' => 'kitanaura', 'description' => 'Lycian Monuments', 'url' => 'https://www.lycianmonuments.com/kitanaura/', 'language' => 'en'],
        ['slug' => 'kitanaura', 'description' => 'kulturportali.gov.tr', 'url' => 'https://www.kulturportali.gov.tr/turkiye/antalya/gezilecekyer/kitanaura', 'language' => 'tr'],
        ['slug' => 'klazomenai', 'description' => 'East-West News', 'url' => 'https://www.eastwestnewsservice.com/turkeys-olive-oil-revival', 'language' => 'en'],
        ['slug' => 'klazomenai', 'description' => 'izmir.ktb.gov.tr', 'url' => 'https://izmir.ktb.gov.tr/TR-77421/klazomenai-urla.html', 'language' => 'tr'],
        ['slug' => 'klazomenai', 'description' => 'Hiç Urla', 'url' => 'https://hicurla.com/en/zeytin-ormanimiz', 'language' => 'en'],
        ['slug' => 'klazomenai', 'description' => 'Urla İskele', 'url' => 'https://urlaiskele.wordpress.com/', 'language' => 'tr'],
        ['slug' => 'kremna', 'description' => 'Hürriyet Daily News', 'url' => 'https://www.hurriyetdailynews.com/pagan-city-kremna-comes-to-surface-186523', 'language' => 'en'],
        ['slug' => 'kremna', 'description' => 'Turizm Ansiklopedisi', 'url' => 'https://turkiyeturizmansiklopedisi.com/kremna-antik-kenti', 'language' => 'tr'],
        ['slug' => 'kremna', 'description' => 'Kültür Envanteri', 'url' => 'https://kulturenvanteri.com/yer/kremna/', 'language' => 'tr'],
        ['slug' => 'kultepe', 'description' => 'Britannica', 'url' => 'https://www.britannica.com/place/Kultepe', 'language' => 'en'],
        ['slug' => 'kultepe', 'description' => 'Ancient Route', 'url' => 'https://ancientroutesturkiye.com/en/kultepe', 'language' => 'en'],
        ['slug' => 'kultepe', 'description' => 'Arkeofili', 'url' => 'https://arkeofili.com/kultepenin-4000-yillik-tabletleri-kadinlarin-ticarette-aktif-oldugunu-gosteriyor/', 'language' => 'tr'],
        ['slug' => 'kultepe', 'description' => 'Antik Rota', 'url' => 'https://ancientroutesturkiye.com/tr/kultepe', 'language' => 'tr'],
        ['slug' => 'kyme', 'description' => 'WildWinds', 'url' => 'https://www.wildwinds.com/coins/greece/aeolis/kyme/i.html', 'language' => 'en'],
        ['slug' => 'kyme', 'description' => 'Turizm Ansiklopedisi', 'url' => 'https://turkiyeturizmansiklopedisi.com/kyme-antik-kenti', 'language' => 'tr'],
        ['slug' => 'kyme', 'description' => 'Kültür Envanteri', 'url' => 'https://kulturenvanteri.com/yer/kyme/', 'language' => 'tr'],
        ['slug' => 'kyon', 'description' => 'Ancient Route', 'url' => 'https://ancientroutesturkiye.com/en/kyon', 'language' => 'en'],
        ['slug' => 'kyon', 'description' => 'Arkeofili', 'url' => 'https://arkeofili.com/muglada-antik-tiyatro-otopark-olarak-kullaniliyor/', 'language' => 'tr'],
        ['slug' => 'kyon', 'description' => 'Kültür Envanteri', 'url' => 'https://kulturenvanteri.com/yer/kyon/', 'language' => 'tr'],
        ['slug' => 'labraunda', 'description' => 'Carian Monuments', 'url' => 'https://www.carianmonuments.com/labraunda', 'language' => 'en'],
        ['slug' => 'labraunda', 'description' => 'kulturportali.gov.tr', 'url' => 'https://www.kulturportali.gov.tr/turkiye/mugla/gezilecekyer/labranda', 'language' => 'tr'],
        ['slug' => 'labraunda', 'description' => 'Daily Sabah', 'url' => 'https://www.dailysabah.com/life/travel/5-impressive-archaeological-sites-to-visit-in-turkiyes-milas', 'language' => 'en'],
        ['slug' => 'labraunda', 'description' => "Etstur Let's Go", 'url' => 'https://www.etstur.com/letsgo/milasta-gezilecek-yerler-en-iyi-48-yer-2025-guncel-etstur-lets-go', 'language' => 'tr'],
        ['slug' => 'laodicea', 'description' => 'Cultural Heritage Online', 'url' => 'https://culturalheritageonline.com/places/laodicea-on-the-lycus-turkey/', 'language' => 'en'],
        ['slug' => 'laodicea', 'description' => 'Nomadic Niko', 'url' => 'https://nomadicniko.com/turkey/laodicea', 'language' => 'en'],
        ['slug' => 'laodicea', 'description' => 'Yolcu360', 'url' => 'https://yolcu360.com/blog/laodikeia-antik-kenti/', 'language' => 'tr'],
        ['slug' => 'laodicea', 'description' => 'Neresi Gezilir', 'url' => 'https://neresigezilir.com.tr/turkiye/denizli/laodikeia-antik-kenti', 'language' => 'tr'],
        ['slug' => 'letoon', 'description' => 'UNESCO', 'url' => 'https://whc.unesco.org/en/list/484', 'language' => 'en'],
        ['slug' => 'letoon', 'description' => 'Turizm Ansiklopedisi', 'url' => 'https://turkiyeturizmansiklopedisi.com/letoon-kutsal-alani', 'language' => 'tr'],
        ['slug' => 'letoon', 'description' => "Turkey's for Life", 'url' => 'https://www.turkeysforlife.com/2012/04/fethiye-day-trip-letoon-to-xanthos-walk.html', 'language' => 'en'],
        ['slug' => 'letoon', 'description' => 'Sırt Çantalı Hikayeler', 'url' => 'https://nafidurmus.com/xanthos-vadisi-gezi-rehberi', 'language' => 'tr'],
        ['slug' => 'magarsus', 'description' => 'Ancient Route', 'url' => 'https://ancientroutesturkiye.com/en/magarsus', 'language' => 'en'],
        ['slug' => 'magarsus', 'description' => 'Adana Başka', 'url' => 'https://www.adanabaska.com/tr/3/adana-baska/bir-baska-tarih/magarsus-antik-kenti/20/166', 'language' => 'tr'],
        ['slug' => 'magarsus', 'description' => 'Anatolian Archaeology', 'url' => 'https://www.anatolianarchaeology.net/excavations-continue-in-the-ancient-city-of-magarsus-where-alexander-the-great-offered-sacrifices', 'language' => 'en'],
        ['slug' => 'magarsus', 'description' => 'Enuygun', 'url' => 'https://www.enuygun.com/bilgi/magarsus-antik-kenti-ni-kesfet', 'language' => 'tr'],
        ['slug' => 'magarsus', 'description' => 'kulturportali.gov.tr', 'url' => 'https://www.kulturportali.gov.tr/turkiye/adana/gezilecekyer/karatas', 'language' => 'tr'],
        ['slug' => 'magnesia', 'description' => 'Turkey Tour Organizer', 'url' => 'https://www.turkeytourorganizer.com/blog/magnesia-ancient-city', 'language' => 'en'],
        ['slug' => 'magnesia', 'description' => 'Saffet Emre Tonguç', 'url' => 'https://www.saffetemretonguc.com/magnesia', 'language' => 'tr'],
        ['slug' => 'magnesia', 'description' => 'Turkish Travel Blog', 'url' => 'https://turkishtravelblog.com/stadium-magnesia-meander-aydin-turkey', 'language' => 'en'],
        ['slug' => 'magnesia', 'description' => "Bi' Gün Yine Yoldayız", 'url' => 'https://bigunyineyoldayiz.com/magnesia-antik-kenti', 'language' => 'tr'],
        ['slug' => 'mamure-castle', 'description' => 'Ancient Route', 'url' => 'https://ancientroutesturkiye.com/en/mamure-castle', 'language' => 'en'],
        ['slug' => 'mamure-castle', 'description' => 'Kültür Envanteri', 'url' => 'https://kulturenvanteri.com/yer/mamure-kalesi/', 'language' => 'tr'],
        ['slug' => 'mamure-castle', 'description' => 'Turkey Photo Guide', 'url' => 'https://turkeyphotoguide.com/anamur-mamure-castle', 'language' => 'en'],
        ['slug' => 'mamure-castle', 'description' => 'Gezimix', 'url' => 'https://gezimix.com.tr/sehir/mersin/tarih-ve-kultur/mersin-anamur-mamure-kalesi-ve-anamur-antik', 'language' => 'tr'],
        ['slug' => 'mausoleum-at-halicarnassus', 'description' => 'Karwansaray', 'url' => 'https://www.karwansaraypublishers.com/blogs/ancient-history-blog/gallery-talk-mausoleum-halikarnassos', 'language' => 'en'],
        ['slug' => 'mausoleum-at-halicarnassus', 'description' => 'BodrumFinder', 'url' => 'https://www.bodrumfinder.com/halikarnas-mozolesi/', 'language' => 'tr'],
        ['slug' => 'mausoleum-at-halicarnassus', 'description' => '4traveler', 'url' => 'https://4traveler.me/en/travel/bodrum/mausoleum-halicarnassus-bodrum', 'language' => 'en'],
        ['slug' => 'mausoleum-at-halicarnassus', 'description' => 'Küçük Dünya', 'url' => 'https://kucukdunya.com/halikarnas-mozolesi-bodrum-mausoleion-anit-muzesi/', 'language' => 'tr'],
        ['slug' => 'melid', 'description' => 'Atlas Anatolia', 'url' => 'https://atlasanatolia.com/site/arslantepe', 'language' => 'en'],
        ['slug' => 'melid', 'description' => 'Arkeolojik Haber', 'url' => 'https://www.arkeolojikhaber.com/haber-arslantepe-hoyugunde-devletlesmenin-izleri-5500-yillik-kiliclar-yeniden-gun-yuzunde-42733/', 'language' => 'tr'],
        ['slug' => 'melid', 'description' => 'The Other Tour', 'url' => 'https://theothertour.com/arslantepe/', 'language' => 'en'],
        ['slug' => 'melid', 'description' => 'Yollardan', 'url' => 'https://www.yollardan.com/arslantepe-hoyugu-bilgileri/', 'language' => 'tr'],
        ['slug' => 'melid', 'description' => 'Arslantepe Portalı', 'url' => 'https://arslantepe.battalgazi.bel.tr', 'language' => 'tr'],
    ];

    /**
     * @var list<array{slug: string, url: string}>
     */
    public const VET_DELETES = [
        ['slug' => 'kitanaura', 'url' => 'https://www.youtube.com/watch?v=eUCKsM2eqNo'],
        ['slug' => 'klazomenai', 'url' => 'http://www.klazomeniaka.com'],
        ['slug' => 'kultepe', 'url' => 'https://web.archive.org/web/20161224084351/http://arkeolojihaber.net/tag/kultepe-hoyugu'],
        ['slug' => 'kyme', 'url' => 'https://steemit.com/blog/@mareseska/ancient-city-series-1'],
        ['slug' => 'kyon', 'url' => 'https://web.archive.org/web/20200107054149/http://www.timestopsmugla.com/tr/kavaklidere/tarih/kyon-antik-kenti'],
        ['slug' => 'letoon', 'url' => 'https://gezimanya.com/GeziNotlari/bir-likya-uclemesi-xanthos-letoon-ve-patara'],
        ['slug' => 'magarsus', 'url' => 'https://web.archive.org/web/20160927003938/http://arkeolojihaber.net/tag/magarsus-antik-kenti'],
        ['slug' => 'magarsus', 'url' => 'https://www.gelgez.net/magarsus-antik-kenti-tarihcesi-ve-kalintilari/'],
        ['slug' => 'magnesia', 'url' => 'https://www.magnesia.org/'],
        ['slug' => 'mamure-castle', 'url' => 'https://en.wikipedia.org/wiki/Aya_Tekla_Church'],
        ['slug' => 'mamure-castle', 'url' => 'https://tr.wikipedia.org/wiki/Silifke#Aya_Tekla'],
        ['slug' => 'mamure-castle', 'url' => 'https://yoldaolmak.com/hiristiyanligin-en-eski-merkezlerinden-aya-tekla-kilisesi.html'],
        ['slug' => 'mausoleum-at-halicarnassus', 'url' => 'https://en.wikipedia.org/wiki/Halicarnassus'],
        ['slug' => 'mausoleum-at-halicarnassus', 'url' => 'https://tr.wikipedia.org/wiki/Halikarnas'],
        ['slug' => 'melid', 'url' => 'https://web.archive.org/web/20161213160415/http://arkeolojihaber.net/tag/arslantepe-hoyugu'],
        ['slug' => 'melid', 'url' => 'http://kendingez.com/malatya-2-orduzu-aslantepe-hoyugu-eski-malatyabattalgazi-eylul-2013-gezi-yazisi'],
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
