<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Curated spike 2 (2026-09-22): story-extender + vibe-check links for
     * 15 ruins (aphrodisias → termessos). Planner slot skipped throughout:
     * every ruin here except midas-monument and oinoanda already has the
     * official badge; those two get planner links in a later pass.
     *
     * Every URL was fetch-verified alive and on-topic before inclusion.
     * Known thin spots kept deliberately: petersommer.com and nytimes.com
     * URLs resolve as "blocked" (bot protection) and are already in the
     * checker's known_blocked_hosts list, so they stay quiet in reports.
     *
     * @var list<array{slug: string, description: string, url: string, language: string}>
     */
    public const CURATED_LINKS = [
        // Aphrodisias — Ara Güler hook.
        ['slug' => 'aphrodisias', 'description' => 'Smithsonian', 'url' => 'https://asia-archive.si.edu/ara-guler-and-the-lost-city-of-aphrodisias', 'language' => 'en'],
        ['slug' => 'aphrodisias', 'description' => 'New York Times', 'url' => 'https://www.nytimes.com/1982/12/26/travel/a-new-life-for-ancient-aphrodisias.html', 'language' => 'en'],
        ['slug' => 'aphrodisias', 'description' => 'Ara Güler Müzesi', 'url' => 'https://aragulermuzesi.com/tr/yayinlar/aphrodisias', 'language' => 'tr'],
        ['slug' => 'aphrodisias', 'description' => 'Arkeofili', 'url' => 'https://arkeofili.com/ara-gulerin-gozunden-tum-ayrintilariyla-aphrodisias-1958/', 'language' => 'tr'],
        // Stratonikeia — love-story hook.
        ['slug' => 'stratonikeia', 'description' => 'UNESCO', 'url' => 'https://whc.unesco.org/en/tentativelists/6041', 'language' => 'en'],
        ['slug' => 'stratonikeia', 'description' => 'Peter Sommer Travels', 'url' => 'https://www.petersommer.com/blog/turkey-travel/stratonikeia', 'language' => 'en'],
        ['slug' => 'stratonikeia', 'description' => 'Arkeofili', 'url' => 'https://arkeofili.com/gladyatorler-sehri-stratonikeia-antik-kentinde-kazilar-basladi/', 'language' => 'tr'],
        ['slug' => 'stratonikeia', 'description' => 'Ekonomim', 'url' => 'https://www.ekonomim.com/yasam-keyfi/stratonikeia-tarihsel-katmanlariyla-en-ilginc-arkeolojik-alanlardan-birisi-haberi-760029', 'language' => 'tr'],
        // Midas Monument — no hook text yet; TR vibe is a genuine gap.
        ['slug' => 'midas-monument', 'description' => 'Livius', 'url' => 'https://www.livius.org/articles/place/yazilikaya-midas-city/', 'language' => 'en'],
        ['slug' => 'midas-monument', 'description' => 'Turkey Photo Guide', 'url' => 'https://www.turkeyphotoguide.com/phrygian-valley', 'language' => 'en'],
        ['slug' => 'midas-monument', 'description' => 'eskisehir.ktb.gov.tr', 'url' => 'https://eskisehir.ktb.gov.tr/TR-336950/yazilikaya-midas-aniti-daglik-frigya.html', 'language' => 'tr'],
        // Assos — Aristotle academy hook.
        ['slug' => 'assos', 'description' => 'UNESCO', 'url' => 'https://whc.unesco.org/en/tentativelists/6242/', 'language' => 'en'],
        ['slug' => 'assos', 'description' => 'Turkish Museums', 'url' => 'https://www.turkishmuseums.com/blog/detail/5-soruda-kazi-alanlari-assos/10031/1', 'language' => 'tr'],
        ['slug' => 'assos', 'description' => 'My Turkey Adventure', 'url' => 'https://myturkeyadventure.com/blog/assos-behramkale-2026-guide', 'language' => 'en'],
        ['slug' => 'assos', 'description' => 'Pegasus Blog', 'url' => 'https://www.flypgs.com/blog/assos-gezi-rehberi-konaklama-noktalari-yemek-duraklari-ve-gorulecek-yerler/', 'language' => 'tr'],
        // Teos — actors' guild + Epicurus hooks.
        ['slug' => 'teos', 'description' => 'Teos Excavation', 'url' => 'https://teos.ankara.edu.tr/en/heritage/the-citys-administrative-commercial-and-social-buildings/theatre/', 'language' => 'en'],
        ['slug' => 'teos', 'description' => 'Visit İzmir', 'url' => 'https://www.visitizmir.org/tr/destinasyon/10263', 'language' => 'tr'],
        ['slug' => 'teos', 'description' => 'Following Hadrian', 'url' => 'https://followinghadrianphotography.com/2024/03/06/teos/', 'language' => 'en'],
        ['slug' => 'teos', 'description' => 'RehberName', 'url' => 'https://www.rehbername.com/seyahat/teos-antik-kenti-rehberi', 'language' => 'tr'],
        // Pergamon — steepest theatre hook.
        ['slug' => 'pergamon', 'description' => 'Biblical Archaeology', 'url' => 'https://www.biblicalarchaeology.org/daily/biblical-sites-places/biblical-archaeology-sites/ancient-pergamon-2/', 'language' => 'en'],
        ['slug' => 'pergamon', 'description' => 'izmir.bel.tr', 'url' => 'https://www.izmir.bel.tr/tr/MekanDetay/64/230', 'language' => 'tr'],
        ['slug' => 'pergamon', 'description' => 'Travelling Trekker', 'url' => 'https://www.travellingtrekker.com/post/what-to-see-at-pergamon-bergama', 'language' => 'en'],
        ['slug' => 'pergamon', 'description' => "Etstur Let's Go", 'url' => 'https://www.etstur.com/letsgo/bergamada-gezilecek-yerler/', 'language' => 'tr'],
        // Sagalassos — mountain city + flowing fountain hooks.
        ['slug' => 'sagalassos', 'description' => 'Google Arts & Culture', 'url' => 'https://artsandculture.google.com/story/sagalassos-the-directorate-general-of-cultural-assets-and-museums-of-Türkiye/rgWBwWbXasy9Gw?hl=en', 'language' => 'en'],
        ['slug' => 'sagalassos', 'description' => 'Somewhere Wonderful', 'url' => 'https://www.somewherewonderful.com/a-visit-to-sagalassos/', 'language' => 'en'],
        ['slug' => 'sagalassos', 'description' => 'Türkiye Turizm', 'url' => 'https://www.turkiyeturizm.com/antoninler-cesmesinin-gizem-dolu-tarihi-75897h.htm', 'language' => 'tr'],
        ['slug' => 'sagalassos', 'description' => 'Yolculuk Terapisi', 'url' => 'https://www.yolculukterapisi.com/sagalassos/', 'language' => 'tr'],
        // Lagina — Hecate sanctuary hook.
        ['slug' => 'lagina', 'description' => 'The Wild Hunt', 'url' => 'https://wildhunt.org/2020/10/temple-of-hecate-at-lagina-and-ancient-practices.html', 'language' => 'en'],
        ['slug' => 'lagina', 'description' => 'Patheos', 'url' => 'https://www.patheos.com/blogs/adamantinemuse/2018/03/a-visit-to-the-temple-of-hekate-lagina/', 'language' => 'en'],
        ['slug' => 'lagina', 'description' => 'RehberName', 'url' => 'https://www.rehbername.com/kesfet/lagina-hekate-tapinagi-nerede-tarihi', 'language' => 'tr'],
        ['slug' => 'lagina', 'description' => 'Küçük Dünya', 'url' => 'https://kucukdunya.com/lagina-tanrica-hekatenin-evi/', 'language' => 'tr'],
        // Phaselis — three harbours + Alexander's winter hooks.
        ['slug' => 'phaselis', 'description' => 'History Hit', 'url' => 'https://www.historyhit.com/locations/phaselis/', 'language' => 'en'],
        ['slug' => 'phaselis', 'description' => 'The Past', 'url' => 'https://the-past.com/review/travel/phaselis-a-city-and-the-sea/', 'language' => 'en'],
        ['slug' => 'phaselis', 'description' => 'KÜRE Ansiklopedi', 'url' => 'https://kureansiklopedi.com/tr/cocuk-detay/phaselis-antik-kenti-1b9f2', 'language' => 'tr'],
        ['slug' => 'phaselis', 'description' => 'Yolda Olmak', 'url' => 'https://yoldaolmak.com/phaselis', 'language' => 'tr'],
        // Aigai — goat-city hook. TR vibe is thin (Hürriyet SEO guide) but the best durable option.
        ['slug' => 'aigai', 'description' => 'aigai.info', 'url' => 'https://aigai.info/en/history/history-ofaigai/', 'language' => 'en'],
        ['slug' => 'aigai', 'description' => 'BBC Türkçe', 'url' => 'https://www.bbc.com/turkce/articles/cewypxvjpgxo', 'language' => 'tr'],
        ['slug' => 'aigai', 'description' => 'Daily Sabah', 'url' => 'https://www.dailysabah.com/life/travel/discovering-aigai-aeolians-city-of-goats-in-western-turkey', 'language' => 'en'],
        ['slug' => 'aigai', 'description' => 'Hürriyet', 'url' => 'https://www.hurriyet.com.tr/seyahat/aigai-antik-kenti-nerede-aigai-antik-kenti-hakkinda-bilgi-tarihi-efsanesi-giris-ucreti-ve-ziyaret-saatleri-2023-41610846', 'language' => 'tr'],
        // Olympus — pirates + Caesar hook.
        ['slug' => 'olympus', 'description' => 'History Hit', 'url' => 'https://www.historyhit.com/locations/olympos/', 'language' => 'en'],
        ['slug' => 'olympus', 'description' => 'Hürriyet', 'url' => 'https://www.hurriyet.com.tr/seyahat/olympos-antik-kenti-nerede-olympos-antik-kenti-hakkinda-bilgi-tarihi-efsanesi-giris-ucreti-ve-ziyaret-saatleri-2023-41608881', 'language' => 'tr'],
        ['slug' => 'olympus', 'description' => 'Explore Lycia', 'url' => 'https://explorelycia.com/blog/cirali-olympos-chimaera', 'language' => 'en'],
        ['slug' => 'olympus', 'description' => 'Biz Evde Yokuz', 'url' => 'https://www.bizevdeyokuz.com/olimpos-agac-evler-gezilecek-yerler-antalya', 'language' => 'tr'],
        // Arykanda — terrace-city hook. TR vibe is a hotel blog; best durable option found.
        ['slug' => 'arykanda', 'description' => 'Livius', 'url' => 'https://www.livius.org/articles/place/arykanda/', 'language' => 'en'],
        ['slug' => 'arykanda', 'description' => 'Turizm Ansiklopedisi', 'url' => 'https://turkiyeturizmansiklopedisi.com/arykanda-antik-kenti', 'language' => 'tr'],
        ['slug' => 'arykanda', 'description' => 'Peter Sommer Travels', 'url' => 'https://www.petersommer.com/blog/turkey-travel/arykanda-lycia', 'language' => 'en'],
        ['slug' => 'arykanda', 'description' => 'Akka Hotels', 'url' => 'https://www.akkahotels.com/tr/blog/arykanda-antik-kenti-gezi-rehber', 'language' => 'tr'],
        // Limyra — Pericles tomb hook. TR vibe is a genuine gap (slowtravelguide.net 500s).
        ['slug' => 'limyra', 'description' => 'Lycian Monuments', 'url' => 'https://www.lycianmonuments.com/limyra', 'language' => 'en'],
        ['slug' => 'limyra', 'description' => 'Art of Wayfaring', 'url' => 'https://artofwayfaring.com/destinations/limyra-ancient-city', 'language' => 'en'],
        ['slug' => 'limyra', 'description' => 'Arkhe Dergisi', 'url' => 'https://www.arkhedergisi.com.tr/limyra-antik-kenti', 'language' => 'tr'],
        // Oenoanda — Diogenes inscription hook. TR vibe is a genuine gap.
        ['slug' => 'oinoanda', 'description' => 'Archaeology Magazine', 'url' => 'https://archaeology.org/issues/july-august-2015/features/turkey-oinoanda-epicurean-inscription/', 'language' => 'en'],
        ['slug' => 'oinoanda', 'description' => 'Livius', 'url' => 'https://www.livius.org/articles/place/oenoanda', 'language' => 'en'],
        ['slug' => 'oinoanda', 'description' => 'Likya Anıtları', 'url' => 'https://www.lycianmonuments.com/tr/oinoanda/', 'language' => 'tr'],
        // Termessos — Alexander-failed-here hook.
        ['slug' => 'termessos', 'description' => 'ktb.gov.tr', 'url' => 'https://www.ktb.gov.tr/EN-114115/pisidia.html', 'language' => 'en'],
        ['slug' => 'termessos', 'description' => 'antalya.ktb.gov.tr', 'url' => 'https://antalya.ktb.gov.tr/TR-310935/termessos.html', 'language' => 'tr'],
        ['slug' => 'termessos', 'description' => 'Whitman College', 'url' => 'https://www.whitman.edu/theatre/theatretour/turkeytravel/letter7/turkeyletter7.htm', 'language' => 'en'],
        ['slug' => 'termessos', 'description' => 'Küçük Dünya', 'url' => 'https://kucukdunya.com/termessos-antik-kenti', 'language' => 'tr'],
    ];

    public function up(): void
    {
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
    }
};
