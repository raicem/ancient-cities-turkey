<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Site types from ruins-scope-classification.csv (2026-08-30 scope session).
     * Periods were deliberately left out: hard to determine, low tourist value.
     *
     * @var array<string, list<int>>
     */
    private array $types = [
        'city' => [1, 2, 3, 4, 7, 8, 9, 10, 12, 13, 14, 15, 16, 17, 19, 20, 21, 23, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 38, 39, 42, 43, 44, 45, 48, 49, 50, 51, 53, 55, 57, 61, 63, 64, 70, 71, 72, 73, 75, 76, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 94, 95, 96, 98, 99, 100, 101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118, 121, 122, 123, 124, 125, 126, 127, 128, 129, 130, 131, 132, 133, 134, 135, 137, 138, 140, 141, 142, 143, 145],
        'fortress' => [6, 41, 65, 74],
        'monument' => [5, 18, 36, 37, 40, 46, 47, 54, 67, 69, 139],
        'religious-complex' => [66, 136],
        'sanctuary' => [11, 22, 24, 52, 56, 68, 77, 97, 120, 144],
    ];

    /**
     * Verified against the official UNESCO list (whc.unesco.org), not the
     * CSV notes, which missed Troy, Pergamon, Ephesus, Aphrodisias, Sardis
     * and Gordion, and wrongly claimed tentative-list Kültepe. Asclepeion
     * is part of the serial Pergamon listing, so it is flagged too.
     *
     * @var list<int>
     */
    private array $unesco = [10, 23, 24, 26, 27, 30, 32, 48, 49, 56, 57, 68, 70, 71, 85];

    /**
     * English display names: international form. Turkish names untouched.
     * Slugs are unaffected (updates bypass Eloquent, slugs never regenerate).
     *
     * @var array<int, array{name: string, other_names: list<string>}>
     */
    private array $names = [
        10 => ['name' => 'Troy', 'other_names' => ['Truva', 'Troia']],
        27 => ['name' => 'Aphrodisias', 'other_names' => ['Afrodisyas']],
        46 => ['name' => 'Roman Bath', 'other_names' => ['Roma Hamamı']],
        47 => ['name' => 'Temple of Augustus', 'other_names' => ['Augustus Tapınağı']],
        18 => ['name' => 'Smyrna Agora', 'other_names' => ['İzmir Agorası']],
        51 => ['name' => 'Kedrai', 'other_names' => ['Sedir Island']],
        70 => ['name' => 'Melid', 'other_names' => ['Arslantepe']],
        137 => ['name' => 'Kastabala', 'other_names' => ['Hierapolis-Kastabala']],
        138 => ['name' => 'Soli', 'other_names' => ['Soli-Pompeiopolis']],
        122 => ['name' => 'Antiphellus', 'other_names' => ['Kaş']],
        130 => ['name' => 'Telmessos', 'other_names' => ['Fethiye']],
        141 => ['name' => 'Herakleia', 'other_names' => ['Herakleia under Latmus']],
    ];

    public function up(): void
    {
        Schema::table('ruins', function (Blueprint $table) {
            $table->string('site_type')->nullable()->after('district');
            $table->json('other_names')->nullable()->after('site_type');
            $table->boolean('is_unesco')->default(false)->after('other_names');
        });

        foreach ($this->types as $type => $ids) {
            DB::table('ruins')->whereIn('id', $ids)->update(['site_type' => $type]);
        }

        DB::table('ruins')->whereIn('id', $this->unesco)->update(['is_unesco' => true]);

        foreach ($this->names as $id => $row) {
            DB::table('ruins')->where('id', $id)->update([
                'name' => $row['name'],
                'other_names' => json_encode($row['other_names']),
            ]);
        }

        DB::table('ruins')->where('id', 38)->update(['city_id' => 43]);
        DB::table('ruins')->where('id', 44)->update(['city_id' => 74]);

        DB::table('links')->where('ruin_id', 132)->delete();
        DB::table('ruins')->where('id', 132)->delete();
    }

    public function down(): void
    {
        Schema::table('ruins', function (Blueprint $table) {
            $table->dropColumn('site_type');
        });

        Schema::table('ruins', function (Blueprint $table) {
            $table->dropColumn('other_names');
        });

        Schema::table('ruins', function (Blueprint $table) {
            $table->dropColumn('is_unesco');
        });
    }
};
