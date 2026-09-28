<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Curated spike 8 (2026-09-28): sixth vet-and-fill wave for 15
     * ruins (metropolis → perperene). 65 fill URLs, all fetch-verified
     * alive and on-topic.
     *
     * VET deletes: frozen archive.org snapshots, dead soft-404s,
     * broken project domain, and generic not-about-site pages
     * (disambiguation, village article, beach stub, book landing, tag
     * archive). Baseline Wikipedia/Tripadvisor links are kept
     * everywhere — two research passes proposed removing them and
     * were overruled.
     *
     * @var list<array{slug: string, description: string, url: string, language: string}>
     */
    public const CURATED_LINKS = [
        ['slug' => 'metropolis', 'description' => 'DEU Arkeoloji', 'url' => 'https://arkeoloji.deu.edu.tr/?lang=en&page_id=1288', 'language' => 'en'],
        ['slug' => 'metropolis', 'description' => 'Turkish Museums', 'url' => 'https://www.turkishmuseums.com/museum/detail/2098-izmir-metropolis-archaeological-site/2098/4', 'language' => 'en'],
        ['slug' => 'metropolis', 'description' => 'Tatildeyap', 'url' => 'https://tatildeyap.com/blog/metropolis-antik-kenti-29', 'language' => 'tr'],
        ['slug' => 'metropolis', 'description' => 'Kültür Portalı', 'url' => 'https://www.kulturportali.gov.tr/turkiye/izmir/gezilecekyer/metropolis-orenyeri', 'language' => 'tr'],
        ['slug' => 'metropolis', 'description' => 'muze.gov.tr', 'url' => 'https://muze.gov.tr/muze-detay?distId=MRK&sectionId=IME01', 'language' => 'tr'],
        ['slug' => 'miletus', 'description' => 'Livius', 'url' => 'https://www.livius.org/articles/place/miletus', 'language' => 'en'],
        ['slug' => 'miletus', 'description' => 'Berlin Devlet Müzeleri', 'url' => 'https://www.smb.museum/en/exhibitions/detail/architecture-of-antiquity', 'language' => 'en'],
        ['slug' => 'miletus', 'description' => 'Milet Kazısı', 'url' => 'https://www.miletgrabung.uni-hamburg.de/tr/milet-tour/tour-stadtzentrum/faustinathermen.html', 'language' => 'tr'],
        ['slug' => 'miletus', 'description' => 'Güney Ege', 'url' => 'https://www.guneyegeturkiye.com/mekan/milet-antik-kenti', 'language' => 'tr'],
        ['slug' => 'mopsuestia', 'description' => 'Archiqoo', 'url' => 'https://archiqoo.com/locations/misis_bridge.php', 'language' => 'en'],
        ['slug' => 'mopsuestia', 'description' => 'Daily Sabah', 'url' => 'https://www.dailysabah.com/arts/ancient-city-of-misis-to-be-new-attraction-center-of-southern-turkey/news', 'language' => 'en'],
        ['slug' => 'mopsuestia', 'description' => 'KÜRE Ansiklopedi', 'url' => 'https://kureansiklopedi.com/tr/detay/misis-koprusu-7db41', 'language' => 'tr'],
        ['slug' => 'mopsuestia', 'description' => 'Adana Gezilecek Yerler', 'url' => 'https://adanagezilecekyerler.com.tr/misis-antik-kenti', 'language' => 'tr'],
        ['slug' => 'mopsuestia', 'description' => 'adana.ktb.gov.tr', 'url' => 'https://adana.ktb.gov.tr/TR-231237/misis-koprusu.html', 'language' => 'tr'],
        ['slug' => 'myra', 'description' => 'National Geographic', 'url' => 'https://www.nationalgeographic.com/history/article/santa-claus-st-nicholas-tomb-archaeology-turkey-spd', 'language' => 'en'],
        ['slug' => 'myra', 'description' => 'Turkish Travel Blog', 'url' => 'https://turkishtravelblog.com/myra-lycian-rock-tombs', 'language' => 'en'],
        ['slug' => 'myra', 'description' => 'Arkeofili', 'url' => 'https://arkeofili.com/demrede-noel-babaya-ilham-veren-azizin-mezari-bulundu', 'language' => 'tr'],
        ['slug' => 'myra', 'description' => 'Küçük Dünya', 'url' => 'https://kucukdunya.com/myra-antik-kenti-ve-noel-baba-kilisesi', 'language' => 'tr'],
        ['slug' => 'neandria', 'description' => 'ToposText', 'url' => 'https://topostext.org/place/397263UNea', 'language' => 'en'],
        ['slug' => 'neandria', 'description' => 'Aeternitas Numismatics', 'url' => 'https://www.aeternitas-numismatics.com/single-post/neandria-turkey', 'language' => 'en'],
        ['slug' => 'neandria', 'description' => 'Arkeofili', 'url' => 'https://arkeofili.com/altin-icin-kaz-daglarindaki-neandria-antik-kenti-gozardi-edildi', 'language' => 'tr'],
        ['slug' => 'neandria', 'description' => 'Ezine Blog', 'url' => 'https://ezine.blog/2025/08/20/neandria', 'language' => 'tr'],
        ['slug' => 'notion', 'description' => "All That's Interesting", 'url' => 'https://allthatsinteresting.com/turkiye-persian-pot-of-gold', 'language' => 'en'],
        ['slug' => 'notion', 'description' => 'IzmirBlog', 'url' => 'https://izmirblog.com/places/notion-ancient-city-history-highlights-and-visitor-guide', 'language' => 'en'],
        ['slug' => 'notion', 'description' => 'Arkeofili', 'url' => 'https://arkeofili.com/izmirdeki-antik-kentte-comlek-icine-saklanmis-sikkeler-kesfedildi', 'language' => 'tr'],
        ['slug' => 'notion', 'description' => 'Menderes Belediyesi', 'url' => 'https://menderes.bel.tr/notion-antik-kenti', 'language' => 'tr'],
        ['slug' => 'nysa', 'description' => 'Turkish Archaeological News', 'url' => 'https://turkisharchaeonews.net/site/nysa-maeander', 'language' => 'en'],
        ['slug' => 'nysa', 'description' => 'Pilgrim Map', 'url' => 'https://www.pilgrimmap.com/site/nysa-5300dd21', 'language' => 'en'],
        ['slug' => 'nysa', 'description' => 'Gezimanya', 'url' => 'https://gezimanya.com/GeziNotlari/aydinda-tarihi-hisset-nysa-antik-kenti', 'language' => 'tr'],
        ['slug' => 'nysa', 'description' => 'Milliyet', 'url' => 'https://www.milliyet.com.tr/cadde/cuneyt-sadic/iki-yakali-kent-nysa-6077142', 'language' => 'tr'],
        ['slug' => 'orthosia', 'description' => 'Hürriyet Daily News', 'url' => 'https://www.hurriyetdailynews.com/gladiators-of-aydin-to-appear-on-3d-screens-48115', 'language' => 'en'],
        ['slug' => 'orthosia', 'description' => 'Turizm Ansiklopedisi', 'url' => 'https://turkiyeturizmansiklopedisi.com/orthosia-antik-kenti', 'language' => 'tr'],
        ['slug' => 'orthosia', 'description' => 'Aydın 24 Haber', 'url' => 'https://www.aydin24haber.com/dogaseverler-yenipazardaki-orthosia-antik-kentini-ziyaret-etti-861991h.htm', 'language' => 'tr'],
        ['slug' => 'orthosia', 'description' => 'ktb.gov.tr', 'url' => 'https://www.ktb.gov.tr/EN-114110/orthosia.html', 'language' => 'en'],
        ['slug' => 'panionium', 'description' => 'Pilgrim Map', 'url' => 'https://www.pilgrimmap.com/site/panionium-4e882fbb', 'language' => 'en'],
        ['slug' => 'panionium', 'description' => 'Wanderlog', 'url' => 'https://wanderlog.com/place/details/8827/%CF%80%CE%B1%CE%BD%CE%B9%CF%8E%CE%BD%CE%B9%CE%BF%CE%BD', 'language' => 'en'],
        ['slug' => 'panionium', 'description' => 'Rehbername', 'url' => 'https://www.rehbername.com/kesfet/panionion-nedir-panion-hakkinda-bilgi', 'language' => 'tr'],
        ['slug' => 'panionium', 'description' => 'Delfin Tercüme', 'url' => 'https://delfintranslation.wordpress.com/tag/panionion-antik-kenti', 'language' => 'tr'],
        ['slug' => 'panionium', 'description' => 'kusadasi.bel.tr', 'url' => 'https://kusadasi.bel.tr/tr/panionion-pv19', 'language' => 'tr'],
        ['slug' => 'parion', 'description' => 'Pilgrim Map', 'url' => 'https://www.pilgrimmap.com/site/parion-47b02c31', 'language' => 'en'],
        ['slug' => 'parion', 'description' => 'Wow Cappadocia', 'url' => 'https://wowcappadocia.com/parion-parium-ancient-city.html', 'language' => 'en'],
        ['slug' => 'parion', 'description' => 'Greek Reporter', 'url' => 'https://greekreporter.com/2026/08/06/parion-ancient-greek-city/', 'language' => 'en'],
        ['slug' => 'parion', 'description' => 'Rehbername', 'url' => 'https://www.rehbername.com/seyahat/parion-antik-kenti', 'language' => 'tr'],
        ['slug' => 'parion', 'description' => 'GeziBilen', 'url' => 'https://gezibilen.com/travelpoint/canakkale/parion-antik-kent', 'language' => 'tr'],
        ['slug' => 'parion', 'description' => 'canakkale.ktb.gov.tr', 'url' => 'https://canakkale.ktb.gov.tr/tr-70579/parion-biga.html', 'language' => 'tr'],
        ['slug' => 'patara', 'description' => 'JPost', 'url' => 'https://www.jpost.com/archaeology/archaeology-around-the-world/article-844316', 'language' => 'en'],
        ['slug' => 'patara', 'description' => 'Pine Beach', 'url' => 'https://www.pinebeach.com.tr/en/blog/patara-ancient-city-travel-guide', 'language' => 'en'],
        ['slug' => 'patara', 'description' => 'Rehbername', 'url' => 'https://www.rehbername.com/seyahat/patara-antik-kenti-rehberi', 'language' => 'tr'],
        ['slug' => 'patara', 'description' => 'Küçük Dünya', 'url' => 'https://kucukdunya.com/patara-antik-kenti-patara-plaji/', 'language' => 'tr'],
        ['slug' => 'pedasa', 'description' => 'Property Turkey', 'url' => 'https://www.propertyturkey.com/about-turkey/about-bodrum/uncover-one-of-the-regions-best-kept-secrets-at-pedasa', 'language' => 'en'],
        ['slug' => 'pedasa', 'description' => 'Bodrum.com.tr', 'url' => 'https://bodrum.com.tr/en/blog/pedasa-ancient-city', 'language' => 'en'],
        ['slug' => 'pedasa', 'description' => 'Suem Travels', 'url' => 'https://suemtravels.com/2013/04/16/ancient-city-of-pedesa/', 'language' => 'en'],
        ['slug' => 'pedasa', 'description' => 'Bodrumdayız', 'url' => 'https://bodrumdayiz.com/pedasa-antik-kenti/', 'language' => 'tr'],
        ['slug' => 'pedasa', 'description' => 'VillaCim', 'url' => 'https://www.villacim.com.tr/pedasa-antik-kenti', 'language' => 'tr'],
        ['slug' => 'pedasa', 'description' => 'kulturportali.gov.tr', 'url' => 'https://www.kulturportali.gov.tr/turkiye/mugla/gezilecekyer/pedasa-antik-kenti', 'language' => 'tr'],
        ['slug' => 'perge', 'description' => 'MacTutor', 'url' => 'https://mathshistory.st-andrews.ac.uk/Biographies/Apollonius/', 'language' => 'en'],
        ['slug' => 'perge', 'description' => 'Lyfe Abroad', 'url' => 'https://lyfeabroad.com/the-ancient-roman-theatre-stadium-at-perge/', 'language' => 'en'],
        ['slug' => 'perge', 'description' => 'TDV İslâm Ansiklopedisi', 'url' => 'https://islamansiklopedisi.org.tr/apollonios-pergeli', 'language' => 'tr'],
        ['slug' => 'perge', 'description' => 'Se Qunun Seyahatnamesi', 'url' => 'https://www.seqununseyahatnamesi.com/perge-gezi-notlarim/', 'language' => 'tr'],
        ['slug' => 'perinthos-heraklia', 'description' => 'CDC', 'url' => 'https://wwwnc.cdc.gov/eid/article/12/6/05-1263_article', 'language' => 'en'],
        ['slug' => 'perinthos-heraklia', 'description' => 'Wikivoyage', 'url' => 'https://en.wikivoyage.org/wiki/Marmara_Ere%C4%9Flisi', 'language' => 'en'],
        ['slug' => 'perinthos-heraklia', 'description' => 'Medya Günlüğü', 'url' => 'https://medyagunlugu.com/eregliden-koronaya/', 'language' => 'tr'],
        ['slug' => 'perinthos-heraklia', 'description' => 'Müthiş Yerler', 'url' => 'https://muthisyerler.com/marmaraereglisi-gezi-rehberi', 'language' => 'tr'],
        ['slug' => 'perinthos-heraklia', 'description' => 'kulturportali.gov.tr', 'url' => 'https://www.kulturportali.gov.tr/turkiye/tekirdag/gezilecekyer/perinthos-antik-kenti', 'language' => 'tr'],
        ['slug' => 'perperene', 'description' => 'BERKSAV', 'url' => 'https://www.berksav.org/2017/kozakyaylasi.asp', 'language' => 'tr'],
    ];

    /**
     * @var list<array{slug: string, url: string}>
     */
    public const VET_DELETES = [
        ['slug' => 'metropolis', 'url' => 'https://web.archive.org/web/20190222170951/http://www.izmirmuzesi.gov.tr/antik-yerlesim-alanlari-metropolis.aspx'],
        ['slug' => 'mopsuestia', 'url' => 'https://web.archive.org/web/20161001145328/http://arkeolojihaber.net/2014/11/08/olumsuzluk-sehri-misis/'],
        ['slug' => 'neandria', 'url' => 'https://web.archive.org/web/20150505175447/http://arkeolojihaber.net/tag/neandria-antik-kenti/'],
        ['slug' => 'notion', 'url' => 'https://arkeodenemeler.blogspot.com/2013/01/notion-yerlesimi-izmir-aiolis-menemen.html'],
        ['slug' => 'nysa', 'url' => 'https://tr.wikipedia.org/wiki/Nysa'],
        ['slug' => 'parion', 'url' => 'https://web.archive.org/web/20170928082643/http://arkeolojihaber.net/tag/parion-antik-kent/'],
        ['slug' => 'parion', 'url' => 'http://www.parion.biz'],
        ['slug' => 'perinthos-heraklia', 'url' => 'http://www.marmaraereglisi.bel.tr/tarihce.aspx'],
    ];

    /**
     * @var list<array{slug: string, url: string, description: string}>
     */
    public const VET_RELABELS = [
        ['slug' => 'metropolis', 'url' => 'https://www.hurriyetdailynews.com/city-of-mother-goddess-opens-to-tourism--70668', 'description' => 'Hürriyet Daily News'],
        ['slug' => 'metropolis', 'url' => 'https://arkeogezi.com/2014/08/18/yanlis-isimli-metropolis/', 'description' => 'Arkeo Gezi'],
        ['slug' => 'orthosia', 'url' => 'https://kariayolu.wordpress.com/karya-kentleri/m-n-o/orthosia/', 'description' => 'kariayolu.wordpress.com'],
        ['slug' => 'parion', 'url' => 'http://www.canakkaletravel.com/galeri/parion-antik-kenti.html', 'description' => 'canakkaletravel.com (foto galeri)'],
    ];

    /**
     * Stored URLs whose pages moved or need scheme/language fixes.
     * Optional description/language keys override those columns too.
     *
     * @var list<array{slug: string, old_url: string, new_url: string, description?: string, language?: string}>
     */
    public const URL_REFRESHES = [
        ['slug' => 'parion', 'old_url' => 'https://troiavakfi.com/harita/parion-biga/', 'new_url' => 'http://troiavakfi.com/harita/parion-biga/', 'language' => 'tr'],
        ['slug' => 'pedasa', 'old_url' => 'http://livelovethank.com/pedasa-antik-kentinde-oksijen-carpmasi/', 'new_url' => 'https://livelovethank.com/tr/pedasa-antik-kentinde-oksijen-carpmasi/'],
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

        foreach (self::URL_REFRESHES as $refresh) {
            $ruinId = DB::table('ruins')->where('slug', $refresh['slug'])->value('id');

            if ($ruinId === null) {
                continue;
            }

            $update = ['url' => $refresh['new_url'], 'updated_at' => now()];

            if (isset($refresh['description'])) {
                $update['description'] = $refresh['description'];
            }

            if (isset($refresh['language'])) {
                $update['language'] = $refresh['language'];
            }

            DB::table('links')
                ->where('ruin_id', $ruinId)
                ->where('url', $refresh['old_url'])
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

        // Vetted-away links and refreshed URLs are intentionally not restored.
    }
};
