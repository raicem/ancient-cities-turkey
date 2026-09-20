<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Curated spike 6 (2026-09-26): fourth vet-and-fill wave for 15
     * ruins (hattusa → kedrai). 58 fill URLs, all fetch-verified alive
     * and on-topic.
     *
     * VET deletes: dead domain (arkeolojidunyasi), repurposed domain
     * snapshot (duygucinar → dental clinic), privatized blog, frozen
     * archive.org snapshots, dead soft-404s, exact-dupe copy, and
     * generic not-about-site pages (village/mahalle articles, beach
     * stub, book landing, tag archive). Baseline Wikipedia/Tripadvisor
     * kept everywhere.
     *
     * @var list<array{slug: string, description: string, url: string, language: string}>
     */
    public const CURATED_LINKS = [
        ['slug' => 'hattusa', 'description' => 'UNESCO', 'url' => 'https://whc.unesco.org/en/list/377', 'language' => 'en'],
        ['slug' => 'hattusa', 'description' => 'Arkeofili', 'url' => 'https://arkeofili.com/kades-hititler-ile-misir-arasindaki-buyuk-savas-ve-baris/', 'language' => 'tr'],
        ['slug' => 'hattusa', 'description' => 'Art of Wayfaring', 'url' => 'https://artofwayfaring.com/destinations/hattusha-the-hittite-capital/', 'language' => 'en'],
        ['slug' => 'hattusa', 'description' => 'Küçük Dünya', 'url' => 'https://kucukdunya.com/hattusa-antik-kenti-hitit-baskenti/', 'language' => 'tr'],
        ['slug' => 'herakleia', 'description' => 'Mythopedia', 'url' => 'https://mythopedia.com/topics/endymion', 'language' => 'en'],
        ['slug' => 'herakleia', 'description' => 'Turizm Ansiklopedisi', 'url' => 'https://turkiyeturizmansiklopedisi.com/herakleia-antik-kenti', 'language' => 'tr'],
        ['slug' => 'herakleia', 'description' => 'Ancient Route', 'url' => 'https://ancientroutesturkiye.com/en/herakleia-at-latmos', 'language' => 'en'],
        ['slug' => 'herakleia', 'description' => 'Küçük Dünya', 'url' => 'https://kucukdunya.com/herakleia-latmos-ay-tanricasi-selenenin-aydinlattigi-sehir/', 'language' => 'tr'],
        ['slug' => 'hierapolis', 'description' => 'UNESCO', 'url' => 'https://whc.unesco.org/en/list/485', 'language' => 'en'],
        ['slug' => 'hierapolis', 'description' => 'Arkeofili', 'url' => 'https://arkeofili.com/hierapolisteki-antik-mucizelerin-sirri-cozulmus-olabilir/', 'language' => 'tr'],
        ['slug' => 'hierapolis', 'description' => 'Time Travel Turtle', 'url' => 'https://www.timetravelturtle.com/turkey/pamukkale-thermal-pools/', 'language' => 'en'],
        ['slug' => 'hierapolis', 'description' => 'Küçük Dünya', 'url' => 'https://kucukdunya.com/pamukkale/', 'language' => 'tr'],
        ['slug' => 'hyllarima', 'description' => 'Türkiye Today', 'url' => 'https://www.turkiyetoday.com/culture/restoration-of-hyllarimas-ancient-fortress-walls-to-boost-tourism-in-mugla-147963', 'language' => 'en'],
        ['slug' => 'hyllarima', 'description' => 'ssmtour', 'url' => 'https://ssmtour.com/turkiye/mugla/hyllarima', 'language' => 'en'],
        ['slug' => 'hyllarima', 'description' => 'Muğla Valiliği', 'url' => 'https://www.mugla.gov.tr/hyllarima-antik-kentindeki-tiyatro-ve-tumulus-turizme-kazandirildi', 'language' => 'tr'],
        ['slug' => 'hyllarima', 'description' => 'mugla.ktb.gov.tr', 'url' => 'https://mugla.ktb.gov.tr/TR-273511/hyllarima.html', 'language' => 'tr'],
        ['slug' => 'iasos', 'description' => 'Turkish Museums', 'url' => 'https://turkishmuseums.com/blog/detail/the-archaeological-site-of-iasos-and-the-legend-of-hermias-and-the-dolphin/10130/4', 'language' => 'en'],
        ['slug' => 'iasos', 'description' => 'Turkish Archaeological News', 'url' => 'https://turkisharchaeonews.net/site/iasos', 'language' => 'en'],
        ['slug' => 'iasos', 'description' => 'Küçük Dünya', 'url' => 'https://kucukdunya.com/iasos-karyada-bir-liman-kenti', 'language' => 'tr'],
        ['slug' => 'iasos', 'description' => 'Gezginimgezgin', 'url' => 'https://gezginimgezgin.com/iosas-antik-kenti-ve-kiyikislacik-koyu-gezi-rehberi-tarih-ve-huzur-elele', 'language' => 'tr'],
        ['slug' => 'idebessos', 'description' => 'Antalya.tc', 'url' => 'https://antalya.tc/explore/ancient-cities/idebessos-ancient-city', 'language' => 'en'],
        ['slug' => 'idebessos', 'description' => 'Kültür Envanteri', 'url' => 'https://kulturenvanteri.com/yer/idebessiois-idebessos/', 'language' => 'tr'],
        ['slug' => 'isaura', 'description' => 'Daily Sabah', 'url' => 'https://www.dailysabah.com/life/history/secrets-of-isaura-ancient-city-waiting-to-be-unearthed', 'language' => 'en'],
        ['slug' => 'isaura', 'description' => 'Ancient Route', 'url' => 'https://ancientroutesturkiye.com/en/isaura', 'language' => 'en'],
        ['slug' => 'isaura', 'description' => 'Turizm Ansiklopedisi', 'url' => 'https://turkiyeturizmansiklopedisi.com/zengibar-kalesi-isaura-arastirmalari', 'language' => 'tr'],
        ['slug' => 'isaura', 'description' => 'Karamandan', 'url' => 'https://www.karamandan.com/makale/27503027/mukremin-kizilca/zengibar-kalesi-bozkir-konya', 'language' => 'tr'],
        ['slug' => 'isaura', 'description' => 'bozkir.gov.tr', 'url' => 'https://www.bozkir.gov.tr/zengibar-kalesi', 'language' => 'tr'],
        ['slug' => 'iznik-castle', 'description' => 'Turkish Archaeological News', 'url' => 'https://turkisharchaeonews.net/object/fortifications-iznik-nicaea', 'language' => 'en'],
        ['slug' => 'iznik-castle', 'description' => 'Told in Stone', 'url' => 'https://toldinstone.com/the-walls-of-nicaea', 'language' => 'en'],
        ['slug' => 'iznik-castle', 'description' => 'Arkeofili', 'url' => 'https://arkeofili.com/iznik-golundeki-kilise-ilk-konsilin-yeri-olabilir-mi', 'language' => 'tr'],
        ['slug' => 'iznik-castle', 'description' => 'Biz Evde Yokuz', 'url' => 'https://www.bizevdeyokuz.com/iznik-gezilecek-yerler', 'language' => 'tr'],
        ['slug' => 'iznik-castle', 'description' => 'iznik.bel.tr', 'url' => 'https://gezirehberi.iznik.bel.tr/', 'language' => 'tr'],
        ['slug' => 'kadyanda', 'description' => 'The Other Tour', 'url' => 'https://theothertour.com/cadyanda/', 'language' => 'en'],
        ['slug' => 'kadyanda', 'description' => 'Turkey Photo Guide', 'url' => 'https://www.turkeyphotoguide.com/kadyanda', 'language' => 'en'],
        ['slug' => 'kadyanda', 'description' => 'Likya Anıtları', 'url' => 'https://www.lycianmonuments.com/tr/kadyanda/', 'language' => 'tr'],
        ['slug' => 'kadyanda', 'description' => "Likya'nın Sesi", 'url' => 'https://likyaninsesi.com/kadyanda-antik-kenti-fethiye-uzumlu-rehberi/', 'language' => 'tr'],
        ['slug' => 'kanlidivane', 'description' => 'Following Hadrian', 'url' => 'https://followinghadrianphotography.com/2021/01/20/kanytelis', 'language' => 'en'],
        ['slug' => 'kanlidivane', 'description' => 'Turkey Photo Guide', 'url' => 'https://www.turkeyphotoguide.com/kanlidivane', 'language' => 'en'],
        ['slug' => 'kanlidivane', 'description' => 'Turkish Museums', 'url' => 'https://www.turkishmuseums.com/museum/detail/2163-mersin-kanli-divane-orenyeri/2163/1', 'language' => 'tr'],
        ['slug' => 'kanlidivane', 'description' => 'Rota Senin', 'url' => 'https://www.rotasenin.com/kanlidivane-antik-kenti', 'language' => 'tr'],
        ['slug' => 'kanlidivane', 'description' => 'muze.gov.tr', 'url' => 'https://muze.gov.tr/muze-detay?DistId=MRK&SectionId=MKD01', 'language' => 'tr'],
        ['slug' => 'karakabakli', 'description' => 'mersin.ktb.gov.tr', 'url' => 'https://mersin.ktb.gov.tr/TR-73147/silifke.html', 'language' => 'tr'],
        ['slug' => 'karatepe-aslantas', 'description' => 'Hittite Monuments', 'url' => 'https://www.hittitemonuments.com/karatepe/index.htm', 'language' => 'en'],
        ['slug' => 'karatepe-aslantas', 'description' => 'Ancient Route', 'url' => 'https://ancientroutesturkiye.com/en/karatepe', 'language' => 'en'],
        ['slug' => 'karatepe-aslantas', 'description' => 'TRT Haber', 'url' => 'https://www.trthaber.com/haber/kultur-sanat/turkiyenin-ilk-acik-hava-muzesi-unescoda-906628.html', 'language' => 'tr'],
        ['slug' => 'karatepe-aslantas', 'description' => 'Gezi Masalı', 'url' => 'https://gezimasali.com/karatepe-aslantas-acik-hava-muzesi', 'language' => 'tr'],
        ['slug' => 'kastabos', 'description' => 'Ancient Route', 'url' => 'https://ancientroutesturkiye.com/en/kastabos', 'language' => 'en'],
        ['slug' => 'kastabos', 'description' => 'Kültür Envanteri', 'url' => 'https://kulturenvanteri.com/yer/kastabos/', 'language' => 'tr'],
        ['slug' => 'kastabos', 'description' => 'Antik Rota', 'url' => 'https://ancientroutesturkiye.com/tr/kastabos', 'language' => 'tr'],
        ['slug' => 'kastabos', 'description' => 'Vici.org', 'url' => 'https://vici.org/vici/28742/', 'language' => 'en'],
        ['slug' => 'kaunos', 'description' => 'Ancient Route', 'url' => 'https://ancientroutesturkiye.com/en/kaunos', 'language' => 'en'],
        ['slug' => 'kaunos', 'description' => 'Livius', 'url' => 'https://www.livius.org/articles/place/kaunos/', 'language' => 'en'],
        ['slug' => 'kaunos', 'description' => 'Kültür Envanteri', 'url' => 'https://kulturenvanteri.com/yer/kaunos/', 'language' => 'tr'],
        ['slug' => 'kaunos', 'description' => 'Küçük Dünya', 'url' => 'https://kucukdunya.com/kaunos-antik-kenti-kaya-mezarlari/', 'language' => 'tr'],
        ['slug' => 'kedrai', 'description' => 'Ancient Route', 'url' => 'https://ancientroutesturkiye.com/en/kedrai', 'language' => 'en'],
        ['slug' => 'kedrai', 'description' => 'Kültür Envanteri', 'url' => 'https://kulturenvanteri.com/yer/kedrai/', 'language' => 'tr'],
        ['slug' => 'kedrai', 'description' => 'Antik Rota', 'url' => 'https://ancientroutesturkiye.com/tr/kedrai', 'language' => 'tr'],
        ['slug' => 'kedrai', 'description' => 'kulturportali.gov.tr', 'url' => 'https://www.kulturportali.gov.tr/turkiye/mugla/gezilecekyer/sedir-adasi', 'language' => 'tr'],
    ];

    /**
     * @var list<array{slug: string, url: string}>
     */
    public const VET_DELETES = [
        ['slug' => 'herakleia', 'url' => 'https://web.archive.org/web/20170213171423/https://duygucinar.com/2017/02/12/herakleia-antik-kent-bafa-golu/'],
        ['slug' => 'hyllarima', 'url' => 'http://www.arkeolojidunyasi.com/antik_kentler/hyllarima.html'],
        ['slug' => 'hyllarima', 'url' => 'https://kariayolu.wordpress.com/karya-kentleri/g-h-i/hyllarima/'],
        ['slug' => 'iasos', 'url' => 'https://tr.wikipedia.org/wiki/Kıyıkışlacık,_Milas'],
        ['slug' => 'idebessos', 'url' => 'https://books.google.com.tr/books?id=0LkyDAAAQBAJ&pg=PA290&lpg=PA290&dq=idebessos&source=bl&ots=glq-ozIxVU&sig=_W9wGHrPpQLD6z2LFb6g7oUVtTU&hl=tr&sa=X&ved=0ahUKEwix15TQmK_WAhUFP5oKHepwCDA4ChDo'],
        ['slug' => 'karakabakli', 'url' => 'http://blog.kavrakoglu.com/tag/karakabaklidaki-bizans-evi/'],
        ['slug' => 'kedrai', 'url' => 'https://en.wikipedia.org/wiki/Sedir_Island'],
        ['slug' => 'kedrai', 'url' => 'https://web.archive.org/web/20190616211624/http://www.ulkemiz.com/kedrai-antik-kenti'],
    ];

    /**
     * @var list<array{slug: string, url: string, description: string}>
     */
    public const VET_RELABELS = [
        ['slug' => 'herakleia', 'url' => 'http://arkeolojigezginleri.blogspot.com/2014/08/herakleia-latmos-herakleiasi.html', 'description' => 'arkeolojigezginleri.blogspot.com'],
        ['slug' => 'iznik-castle', 'url' => 'https://www.kulturportali.gov.tr/turkiye/bursa/gezilecekyer/znik-surlari', 'description' => 'kulturportali.gov.tr'],
        ['slug' => 'kadyanda', 'url' => 'https://yoldaolmak.com/kadyanda-antik-kenti.html', 'description' => 'yoldaolmak.com'],
        ['slug' => 'karatepe-aslantas', 'url' => 'https://osmaniye.ktb.gov.tr/TR-161049/karatepe---aslantas-acik-hava-muzesi.html', 'description' => 'osmaniye.ktb.gov.tr'],
    ];

    /**
     * Stored URLs whose pages moved to a new canonical address.
     *
     * @var list<array{slug: string, old_url: string, new_url: string}>
     */
    public const URL_REFRESHES = [
        ['slug' => 'kaunos', 'old_url' => 'https://www.rotasenin.com/kaunos-antik-kenti', 'new_url' => 'https://www.rotasenin.com/kaunos-antik-kenti-dalyan-kral-mezarlari'],
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

            DB::table('links')
                ->where('ruin_id', $ruinId)
                ->where('url', $refresh['old_url'])
                ->update(['url' => $refresh['new_url'], 'updated_at' => now()]);
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
