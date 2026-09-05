<?php

use App\Link;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * Link hosts verified dead on 2026-09-05: NXDOMAIN / parked /
     * hijacked / persistently unreachable (see links:check report).
     * Stored without scheme and without www; matching strips www too.
     *
     * @var list<string>
     */
    public const DEAD_HOSTS = [
        'teosarkeoloji.com',
        'sivrihisar.web.tr',
        'sehirkacaklari.com',
        'geziantalya.com',
        'duygutuncer.com',
        'zeugmaweb.com',
        'alacahoyukkazisi.com',
        'geziseli.com',
        'turcom.net',
        'timestopsmugla.com',
        'anatoliancrossroads.com',
        'sahindogan.com',
        'phaselis.org',
        'benolmeden.com',
        'goseydisehir.com',
        'arkeopolis.com',
        'pudra.com',
    ];

    public function up(): void
    {
        $deleted = [];

        Link::query()->chunkById(200, function ($links) use (&$deleted): void {
            foreach ($links as $link) {
                if (in_array(self::normalizeHost($link->url), self::DEAD_HOSTS, true)) {
                    $deleted[] = $link->url;
                    $link->delete();
                }
            }
        });

        if ($deleted !== []) {
            Log::info('Deleted links on dead domains', $deleted);
        }
    }

    public function down(): void
    {
        // Data-only cleanup, intentionally not reversible.
    }

    public static function normalizeHost(string $url): ?string
    {
        if (! str_contains($url, '://')) {
            $url = 'http://' . $url;
        }

        $host = parse_url($url, PHP_URL_HOST);

        if (! is_string($host) || $host === '') {
            return null;
        }

        return preg_replace('/^www\./', '', strtolower($host));
    }
};
