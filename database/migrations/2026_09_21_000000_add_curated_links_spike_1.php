<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Curated spike 1 (2026-09-21): story-extender + vibe-check links for
     * ephesus, aspendos, knidos, kilistra and lysias, plus planner links
     * only where no official badge exists (kilistra, lysias). Every URL was
     * fetch-verified alive and on-topic before inclusion.
     *
     * Also removes the factually wrong Knidos Tripadvisor URL (it points to
     * Termessos), drops the duplicate Aspendos Ekşi Sözlük entry and fixes
     * the mislabeled Aspendos Vikipedi description.
     *
     * @var list<array{slug: string, description: string, url: string, language: string}>
     */
    public const CURATED_LINKS = [
        ['slug' => 'ephesus', 'description' => 'Britannica', 'url' => 'https://www.britannica.com/topic/Seven-Sleepers-of-Ephesus', 'language' => 'en'],
        ['slug' => 'ephesus', 'description' => 'İGA Blog', 'url' => 'https://www.istairport.com/blog/efes-antik-kenti-ve-yedi-uyuyanlar-efsanesi', 'language' => 'tr'],
        ['slug' => 'ephesus', 'description' => "Turkey's for Life", 'url' => 'https://www.turkeysforlife.com/2018/02/ephesus-ancient-ruins.html', 'language' => 'en'],
        ['slug' => 'ephesus', 'description' => 'Biz Evde Yokuz', 'url' => 'https://www.bizevdeyokuz.com/efes-antik-kenti', 'language' => 'tr'],
        ['slug' => 'aspendos', 'description' => 'History Hit', 'url' => 'https://www.historyhit.com/locations/aspendos-roman-theatre', 'language' => 'en'],
        ['slug' => 'aspendos', 'description' => 'Hikayelerimizden', 'url' => 'https://hikayelerimizden.com/efsaneler/belkis.html', 'language' => 'tr'],
        ['slug' => 'aspendos', 'description' => 'Antalya Diary', 'url' => 'https://antalyadiary.com/en/attractions/aspendos-ancient-theatre', 'language' => 'en'],
        ['slug' => 'knidos', 'description' => 'The Art Story', 'url' => 'https://www.theartstory.org/blog/the-male-gaze-made-marble-the-aphrodite-of-knidos-by-the-ancient-greek-praxiteles', 'language' => 'en'],
        ['slug' => 'knidos', 'description' => 'Armağan Portakal', 'url' => 'https://www.armaganportakal.com/knidos-antik-kenti-ve-afrodit-heykeli', 'language' => 'tr'],
        ['slug' => 'knidos', 'description' => 'Nomadic Niko', 'url' => 'https://nomadicniko.com/turkey/knidos', 'language' => 'en'],
        ['slug' => 'knidos', 'description' => 'Gizemce Keşifler', 'url' => 'https://www.gizemcekesifler.com/knidos/', 'language' => 'tr'],
        ['slug' => 'kilistra', 'description' => 'All About Turkey', 'url' => 'https://allaboutturkey.com/lystra.html', 'language' => 'en'],
        ['slug' => 'kilistra', 'description' => 'Gezimanya', 'url' => 'https://gezimanya.com/konya/gezilecek-yerler/kilistra-antik-kenti', 'language' => 'tr'],
        ['slug' => 'kilistra', 'description' => 'Yenihaberden', 'url' => 'https://www.yenihaberden.com/yazi/omer-tokgoz/konya-nin-peri-bacalari-diyari-klistra/17177', 'language' => 'tr'],
        ['slug' => 'kilistra', 'description' => 'konya.ktb.gov.tr', 'url' => 'https://konya.ktb.gov.tr/TR-370546/meram.html', 'language' => 'tr'],
        ['slug' => 'kilistra', 'description' => 'Pilgrimaps', 'url' => 'https://www.pilgrimaps.com/archaeologycal-site-of-kilistra', 'language' => 'en'],
        ['slug' => 'lysias', 'description' => 'WildWinds', 'url' => 'https://www.wildwinds.com/coins/greece/phrygia/lysias/i.html', 'language' => 'en'],
        ['slug' => 'lysias', 'description' => 'Antik Rota', 'url' => 'https://ancientroutesturkiye.com/tr/lysias', 'language' => 'tr'],
        ['slug' => 'lysias', 'description' => 'Vici.org', 'url' => 'https://vici.org/vici/64076/', 'language' => 'en'],
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

        // Wrong-site link: the Knidos Tripadvisor URL points to Termessos.
        $knidosId = DB::table('ruins')->where('slug', 'knidos')->value('id');

        if ($knidosId !== null) {
            DB::table('links')
                ->where('ruin_id', $knidosId)
                ->where('url', 'like', '%Termessos%')
                ->delete();
        }

        // Duplicate: keep the general Aspendos Ekşi Sözlük entry.
        $aspendosId = DB::table('ruins')->where('slug', 'aspendos')->value('id');

        if ($aspendosId !== null) {
            DB::table('links')
                ->where('ruin_id', $aspendosId)
                ->where('url', 'https://eksisozluk.com/aspendos-antik-tiyatrosu--48465')
                ->delete();

            DB::table('links')
                ->where('ruin_id', $aspendosId)
                ->where('url', 'https://tr.wikipedia.org/wiki/Aspendos')
                ->update(['description' => 'Vikipedi']);
        }
    }

    public function down(): void
    {
        foreach (self::CURATED_LINKS as $link) {
            DB::table('links')->where('url', $link['url'])->delete();
        }

        // Deleted wrong-site/duplicate links are intentionally not restored.
    }
};
