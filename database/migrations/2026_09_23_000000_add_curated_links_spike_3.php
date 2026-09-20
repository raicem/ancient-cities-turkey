<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Curated spike 3 (2026-09-23): first combined vet-and-fill wave for
     * 15 ruins (adada → antioch-of-pisidia). Every fill URL was
     * fetch-verified alive and on-topic before inclusion, except the
     * turkishmuseums.com Anemurium EN planner which 503s to scripted
     * fetches (bot-wall) and is deliberately left as a gap.
     *
     * VET deletes: dead/parked domains (aizanoi.com ×2), frozen
     * archive.org snapshots of dead sites (ainos ×2, phaselis ×2),
     * gossip junk (milliyet Müge Anlı), and generic king-not-site pages
     * (midas ×2). VET relabels fix stale descriptions left by earlier URL
     * swaps (anavarza, ani, midas, phaselis) and typos (alahan, alinda).
     *
     * Orphans (links whose ruin_id matches no ruin, from old deleted ruin
     * rows): re-attached where the live ruin lacks the URL (perge ×2,
     * phaselis ×2), other orphans deleted.
     *
     * @var list<array{slug: string, description: string, url: string, language: string}>
     */
    public const CURATED_LINKS = [
        ['slug' => 'adada', 'description' => 'Hürriyet Daily News', 'url' => 'https://www.hurriyetdailynews.com/ancient-city-reveals-traces-of-17-centuries-of-uninterrupted-life-221078', 'language' => 'en'],
        ['slug' => 'adada', 'description' => 'Alaturka', 'url' => 'https://www.alaturka.info/en/turkey-country/riviera/5324-adada-basilicas-and-imperial-temples-in-the-forgotten-city', 'language' => 'en'],
        ['slug' => 'adada', 'description' => 'Yeşil Sütçüler', 'url' => 'https://www.yesilsutculer.com/adada-antik-kenti-sagrak-koyu/', 'language' => 'tr'],
        ['slug' => 'adada', 'description' => 'Ölümüne Yaşamak', 'url' => 'https://olumuneyasamak.wordpress.com/2017/09/08/st-paul-yolu-antalyadan-adada-antik-kentine/', 'language' => 'tr'],
        ['slug' => 'adada', 'description' => 'kulturportali.gov.tr', 'url' => 'https://www.kulturportali.gov.tr/turkiye/isparta/gezilecekyer/adada-antik-kenti', 'language' => 'tr'],
        ['slug' => 'agora-of-smyrna', 'description' => 'Smyrna Agorası', 'url' => 'https://www.smyrnaagorasi.com/en/ancient-smyrna/', 'language' => 'en'],
        ['slug' => 'agora-of-smyrna', 'description' => 'Nomadic Niko', 'url' => 'https://nomadicniko.com/2013/10/20/smyrna-agora/', 'language' => 'en'],
        ['slug' => 'agora-of-smyrna', 'description' => 'Rota Senin', 'url' => 'https://www.rotasenin.com/smyrna-agorasi', 'language' => 'tr'],
        ['slug' => 'agora-of-smyrna', 'description' => 'Sina Yüksel', 'url' => 'https://www.sinasiyuksel.com/blog/?p=60881', 'language' => 'tr'],
        ['slug' => 'ainos', 'description' => 'GoTürkiye', 'url' => 'https://goturkiye.com/culturaljourneys/ainos', 'language' => 'en'],
        ['slug' => 'ainos', 'description' => 'Turkish Archaeological News', 'url' => 'https://turkisharchaeonews.net/object/enez-castle', 'language' => 'en'],
        ['slug' => 'ainos', 'description' => 'Edebiyat ve Sanat Akademisi', 'url' => 'http://edebiyatvesanatakademisi.com/post/ainos-enez-antik-kenti/80306', 'language' => 'tr'],
        ['slug' => 'ainos', 'description' => 'Yolcu360', 'url' => 'https://yolcu360.com/blog/enez-gezilecek-yerler/', 'language' => 'tr'],
        ['slug' => 'ainos', 'description' => 'edirne.ktb.gov.tr', 'url' => 'https://edirne.ktb.gov.tr/TR-76439/enez-ilcesi.html', 'language' => 'tr'],
        ['slug' => 'aizanoi', 'description' => 'Hürriyet Daily News', 'url' => 'https://www.hurriyetdailynews.com/worlds-first-stock-exchange-was-in-turkey-143419', 'language' => 'en'],
        ['slug' => 'aizanoi', 'description' => 'Nomadic Niko', 'url' => 'https://nomadicniko.com/2013/03/15/aizanoi/', 'language' => 'en'],
        ['slug' => 'aizanoi', 'description' => 'Aizanoi Kazısı', 'url' => 'https://aizanoi.dpu.edu.tr/tr/index/sayfa/13872/macellum-borsa', 'language' => 'tr'],
        ['slug' => 'aizanoi', 'description' => 'Hürriyet', 'url' => 'https://www.hurriyet.com.tr/yazarlar/ugur-celikkol/trenle-aizanoi-antik-kentine-gittik-42127319', 'language' => 'tr'],
        ['slug' => 'alabanda', 'description' => 'Bike Classical', 'url' => 'https://bikeclassical.blogspot.com/2016/05/alabanda-city-of-stallions.html', 'language' => 'en'],
        ['slug' => 'alabanda', 'description' => 'Told in Stone', 'url' => 'https://toldinstone.com/bayram-bling/', 'language' => 'en'],
        ['slug' => 'alabanda', 'description' => 'Tatil.net.tr', 'url' => 'https://www.tatil.net.tr/alabanda-antik-kenti-gezi-ve-tatil-rehberi.html', 'language' => 'tr'],
        ['slug' => 'alabanda', 'description' => 'Küçük Dünya', 'url' => 'https://kucukdunya.com/alabanda-kultur-zenginlik-eglence-sehri/', 'language' => 'tr'],
        ['slug' => 'alacahoyuk', 'description' => 'Turkish Archaeological News', 'url' => 'https://turkisharchaeonews.net/site/alacah%C3%B6y%C3%BCk', 'language' => 'en'],
        ['slug' => 'alacahoyuk', 'description' => 'Following Hadrian', 'url' => 'https://followinghadrianphotography.com/2016/08/01/alacahoyuk/', 'language' => 'en'],
        ['slug' => 'alacahoyuk', 'description' => 'Müzedenal', 'url' => 'https://www.muzedenal.com/hitit-gunes-kursu-ne-anlatiyor', 'language' => 'tr'],
        ['slug' => 'alacahoyuk', 'description' => 'Küçük Dünya', 'url' => 'https://kucukdunya.com/alaca-hoyuk-antik-kenti/', 'language' => 'tr'],
        ['slug' => 'alahan-monastery', 'description' => 'The Byzantine Legacy', 'url' => 'https://www.thebyzantinelegacy.com/alahan-monastery', 'language' => 'en'],
        ['slug' => 'alahan-monastery', 'description' => 'Travel Adventures', 'url' => 'https://www.traveladventures.org/continents/europe/alahan-monastery.html', 'language' => 'en'],
        ['slug' => 'alahan-monastery', 'description' => 'Kültür Envanteri', 'url' => 'https://kulturenvanteri.com/yer/alahan-manastiri', 'language' => 'tr'],
        ['slug' => 'alexandria-troas', 'description' => 'Voyage Turkey', 'url' => 'https://voyageturkey.net/alexandria-troas', 'language' => 'en'],
        ['slug' => 'alexandria-troas', 'description' => 'Turkey Travel Planner', 'url' => 'https://turkeytravelplanner.com/go/Aegean/alexandria_troas/index.html', 'language' => 'en'],
        ['slug' => 'alexandria-troas', 'description' => "Çanakkale'yi Seviyoruz", 'url' => 'https://www.canakkaleyiseviyoruz.com/blog/alexandria-troas-antik-kenti-rehberi', 'language' => 'tr'],
        ['slug' => 'alexandria-troas', 'description' => 'muze.gov.tr', 'url' => 'https://muze.gov.tr/muze-detay?DistId=MRK&SectionId=CAL01', 'language' => 'tr'],
        ['slug' => 'alinda', 'description' => 'Britannica', 'url' => 'https://www.britannica.com/biography/Ada-ruler-of-Halicarnassus', 'language' => 'en'],
        ['slug' => 'alinda', 'description' => 'Claire Cox', 'url' => 'https://clairecox.org/turkey2005_1', 'language' => 'en'],
        ['slug' => 'alinda', 'description' => 'Bodrum Life', 'url' => 'https://www.bodrumlife.com.tr/surgun-prenses-ada', 'language' => 'tr'],
        ['slug' => 'alinda', 'description' => 'Ses Gazetesi', 'url' => 'https://www.sesgazetesi.com.tr/buyuk-iskenderin-aydinda-fethedemedigi-kent-kralice-yonetmisti', 'language' => 'tr'],
        ['slug' => 'amorium', 'description' => 'Met Museum', 'url' => 'https://www.metmuseum.org/essays/the-byzantine-city-of-amorium', 'language' => 'en'],
        ['slug' => 'amorium', 'description' => 'Turizm Ansiklopedisi', 'url' => 'https://turkiyeturizmansiklopedisi.com/amorium-emirdag-antik-kenti', 'language' => 'tr'],
        ['slug' => 'amorium', 'description' => 'kulturportali.gov.tr', 'url' => 'https://www.kulturportali.gov.tr/turkiye/afyonkarahisar/gezilecekyer/amorium-antik-kenti', 'language' => 'tr'],
        ['slug' => 'anavarza-1', 'description' => 'Hürriyet Daily News', 'url' => 'https://www.hurriyetdailynews.com/ancient-hygieia-new-finding-in-anavarza-123138', 'language' => 'en'],
        ['slug' => 'anavarza-1', 'description' => 'Çerçi Yusuf', 'url' => 'https://www.cerciyusuf.org/anavarza', 'language' => 'tr'],
        ['slug' => 'anavarza-1', 'description' => 'Ancient Route', 'url' => 'https://ancientroutesturkiye.com/en/anavarza', 'language' => 'en'],
        ['slug' => 'anavarza-1', 'description' => 'Yolda Olmak', 'url' => 'https://yoldaolmak.com/anavarza-antik-kenti', 'language' => 'tr'],
        ['slug' => 'anemurium', 'description' => 'Livius', 'url' => 'https://www.livius.org/articles/place/anemurium-anamur', 'language' => 'en'],
        ['slug' => 'anemurium', 'description' => 'kulturportali.gov.tr', 'url' => 'https://www.kulturportali.gov.tr/turkiye/mersin/gezilecekyer/anemurium-antik-kenti', 'language' => 'tr'],
        ['slug' => 'anemurium', 'description' => 'Turkish Archaeological News', 'url' => 'https://turkisharchaeonews.net/site/anemurium', 'language' => 'en'],
        ['slug' => 'anemurium', 'description' => 'muze.gov.tr', 'url' => 'https://muze.gov.tr/muze-detay?distId=MRK&sectionId=ANM01', 'language' => 'tr'],
        ['slug' => 'ani', 'description' => 'UNESCO', 'url' => 'https://whc.unesco.org/en/list/1518', 'language' => 'en'],
        ['slug' => 'ani', 'description' => 'Relentless Roaming', 'url' => 'https://relentlessroaming.com/how-to-visit-ani/', 'language' => 'en'],
        ['slug' => 'ani', 'description' => 'Küçük Dünya', 'url' => 'https://kucukdunya.com/kafkaslardan-anadoluya-gecisin-kalesi-ani/', 'language' => 'tr'],
        ['slug' => 'ani', 'description' => 'Journavel', 'url' => 'https://www.journavel.com/kars-ani-harabeleri-gezilecek-yerler/', 'language' => 'tr'],
        ['slug' => 'antandros', 'description' => 'Aeneas Route', 'url' => 'https://www.aeneasroute.org/en/tour/antandros/', 'language' => 'en'],
        ['slug' => 'antandros', 'description' => 'Orion Adatepe', 'url' => 'https://orionadatepe.com/en/discover-the-northern-aegean/antandros-ancient-city', 'language' => 'en'],
        ['slug' => 'antandros', 'description' => 'İdavilla', 'url' => 'https://www.idavilla.com.tr/antandros-antik-kenti-1', 'language' => 'tr'],
        ['slug' => 'antandros', 'description' => "Bi' Gün Yine Yoldayız", 'url' => 'https://bigunyineyoldayiz.com/antandros-antik-kenti/', 'language' => 'tr'],
        ['slug' => 'antandros', 'description' => 'GoTürkiye', 'url' => 'https://goturkiye.com/culturaljourneys/ancient-city-of-antandros', 'language' => 'en'],
        ['slug' => 'antioch-of-pisidia', 'description' => 'Ancient Dan', 'url' => 'https://ancientdan.com/2019/05/05/pisidian-antioch-genesis-of-the-accepting-church/', 'language' => 'en'],
        ['slug' => 'antioch-of-pisidia', 'description' => 'Mundelein Seminary', 'url' => 'https://usml.edu/our-visit-to-antioch-of-pisidia/', 'language' => 'en'],
        ['slug' => 'antioch-of-pisidia', 'description' => 'Turizm Ansiklopedisi', 'url' => 'https://turkiyeturizmansiklopedisi.com/pisidia-antiocheiasi-men-tapinagi-kutsal-alani', 'language' => 'tr'],
        ['slug' => 'antioch-of-pisidia', 'description' => "Bi' Gün Yine Yoldayız", 'url' => 'https://bigunyineyoldayiz.com/pisidia-antiokheia-antik-kenti/', 'language' => 'tr'],
        ['slug' => 'antioch-of-pisidia', 'description' => 'kulturportali.gov.tr', 'url' => 'https://www.kulturportali.gov.tr/turkiye/isparta/gezilecekyer/pisidia-antiokheia', 'language' => 'tr'],
    ];

    /**
     * @var list<array{slug: string, url: string}>
     */
    public const VET_DELETES = [
        ['slug' => 'ainos', 'url' => 'https://web.archive.org/web/20171008090238/http://arkeolojihaber.net/tag/ainos-antik-kenti/'],
        ['slug' => 'ainos', 'url' => 'https://web.archive.org/web/20190708220629/http://enezkazisi.org/'],
        ['slug' => 'ainos', 'url' => 'http://www.milliyet.com.tr/muge-anli-2600-yillik-tarihi-magazin-2519380/?utm_source=twitter.com'],
        ['slug' => 'aizanoi', 'url' => 'http://www.aizanoi.com'],
        ['slug' => 'phaselis', 'url' => 'https://web.archive.org/web/20160325013337/http://www.phaselis.org/en/'],
        ['slug' => 'phaselis', 'url' => 'https://web.archive.org/web/20160527202630/http://www.phaselis.org/'],
        ['slug' => 'midas-monument', 'url' => 'https://en.wikipedia.org/wiki/Midas'],
        ['slug' => 'midas-monument', 'url' => 'https://tr.wikipedia.org/wiki/Midas'],
    ];

    /**
     * @var list<array{slug: string, url: string, description: string}>
     */
    public const VET_RELABELS = [
        ['slug' => 'ainos', 'url' => 'https://www.tripadvisor.com.tr/Attraction_Review-g652369-d4328393-Reviews-Enez_Castle-Edirne_Edirne_Province.html', 'description' => 'Enez Castle (ancient acropolis)'],
        ['slug' => 'alahan-monastery', 'url' => 'https://tr.wikipedia.org/wiki/Alahan_Manastırı', 'description' => 'Vikipedi'],
        ['slug' => 'alinda', 'url' => 'https://en.wikipedia.org/wiki/Alinda', 'description' => 'Wikipedia'],
        ['slug' => 'anavarza-1', 'url' => 'https://muze.gov.tr/muze-detay?SectionId=ADV01&DistId=MRK', 'description' => 'muze.gov.tr'],
        ['slug' => 'ani', 'url' => 'https://muze.gov.tr/muze-detay?DistId=MRK&SectionId=ANI01', 'description' => 'muze.gov.tr'],
        ['slug' => 'midas-monument', 'url' => 'https://eskisehir.ktb.gov.tr/TR-336950/yazilikaya-midas-aniti-daglik-frigya.html', 'description' => 'eskisehir.ktb.gov.tr'],
        ['slug' => 'phaselis', 'url' => 'https://muze.gov.tr/muze-detay?DistId=PHS&SectionId=PHS01', 'description' => 'muze.gov.tr'],
    ];

    /**
     * Orphan links (ruin_id matches no ruin) worth rescuing: re-attached
     * to the live ruin when it lacks the URL.
     *
     * @var list<array{url: string, slug: string}>
     */
    public const ORPHAN_REATTACH = [
        ['url' => 'https://gezmekguzelsey.com/side-perge-antik-kentleri-antalya/', 'slug' => 'perge'],
        ['url' => 'http://www.turkeysforlife.com/2016/07/perge-ruins-antalya.html', 'slug' => 'perge'],
        ['url' => 'http://turkishtravelblog.com/phaselis/', 'slug' => 'phaselis'],
        ['url' => 'http://www.routesandtrips.com/lycian-way-a-walk-to-phaselis-ruins/', 'slug' => 'phaselis'],
    ];

    public function up(): void
    {
        $liveIds = DB::table('ruins')->pluck('id');

        foreach (self::ORPHAN_REATTACH as $rescue) {
            $ruinId = DB::table('ruins')->where('slug', $rescue['slug'])->value('id');

            if ($ruinId === null) {
                continue;
            }

            // Only still-orphaned rows qualify for rescue; on re-runs the
            // rescued link already lives on the ruin and must be kept.
            $orphan = DB::table('links')
                ->where('url', $rescue['url'])
                ->whereNotIn('ruin_id', $liveIds)
                ->first();

            if ($orphan === null) {
                continue;
            }

            $alreadyLinked = DB::table('links')
                ->where('ruin_id', $ruinId)
                ->where('url', $rescue['url'])
                ->exists();

            if ($alreadyLinked) {
                DB::table('links')->where('id', $orphan->id)->delete();
            } else {
                DB::table('links')->where('id', $orphan->id)->update(['ruin_id' => $ruinId]);
            }
        }

        // Remaining orphans point at deleted ruins and render nowhere.
        DB::table('links')->whereNotIn('ruin_id', $liveIds)->delete();

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

        // Vetted-away and orphan links are intentionally not restored.
    }
};
