<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Verified live in September 2026. The old muze.gov.tr/en/museums and
     * muze.gov.tr/tr/muzeler URL schemes now serve 404 pages.
     *
     * @var array<int, string>
     */
    private array $fixedUrls = [
        10 => 'https://muzeler.org/muze/troya-antik-kenti/',
        11 => 'https://muzeler.org/muze/apollon-smintheion/',
        30 => 'https://muzeler.org/muze/manisa-sardes-oren-yeri-ve-artemis-tapinagi/',
        73 => 'https://muzeler.org/muze/hasankeyf-orenyeri/',
        103 => 'https://muze.gov.tr/muze-detay?DistId=MRK&SectionId=ADV01',
        144 => 'https://muzeler.org/muze/labranda-antik-kenti/',
    ];

    public function up(): void
    {
        Schema::table('ruins', function (Blueprint $table) {
            $table->string('official_site_url')->nullable()->after('official_site_en');
        });

        DB::table('ruins')->update(['official_site_url' => DB::raw('official_site_tr')]);

        foreach ($this->fixedUrls as $id => $url) {
            DB::table('ruins')->where('id', $id)->update(['official_site_url' => $url]);
        }

        Schema::table('ruins', function (Blueprint $table) {
            $table->dropColumn('official_site');
        });

        Schema::table('ruins', function (Blueprint $table) {
            $table->dropColumn('official_site_tr');
        });

        Schema::table('ruins', function (Blueprint $table) {
            $table->dropColumn('official_site_en');
        });
    }

    public function down(): void
    {
        Schema::table('ruins', function (Blueprint $table) {
            $table->boolean('official_site')->default(0);
            $table->string('official_site_tr')->nullable();
            $table->string('official_site_en')->nullable();
        });

        DB::table('ruins')->whereNotNull('official_site_url')->update([
            'official_site' => 1,
            'official_site_tr' => DB::raw('official_site_url'),
        ]);

        Schema::table('ruins', function (Blueprint $table) {
            $table->dropColumn('official_site_url');
        });
    }
};
