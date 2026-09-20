<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Moves the per-ruin tripadvisor URL into the links table, where the
     * frontend has rendered it since the sidebar hierarchy rework.
     */
    public function up(): void
    {
        $ruins = DB::table('ruins')
            ->whereNotNull('tripadvisor')
            ->where('tripadvisor', '!=', '')
            ->get(['id', 'tripadvisor']);

        foreach ($ruins as $ruin) {
            $alreadyLinked = DB::table('links')
                ->where('ruin_id', $ruin->id)
                ->where('url', $ruin->tripadvisor)
                ->exists();

            if ($alreadyLinked) {
                continue;
            }

            DB::table('links')->insert([
                'ruin_id' => $ruin->id,
                'description' => 'Tripadvisor',
                'url' => $ruin->tripadvisor,
                'language' => 'en',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::table('ruins', function (Blueprint $table) {
            $table->dropColumn('tripadvisor');
        });
    }

    public function down(): void
    {
        Schema::table('ruins', function (Blueprint $table) {
            $table->string('tripadvisor')->nullable();
        });

        $links = DB::table('links')
            ->where('description', 'Tripadvisor')
            ->where('language', 'en')
            ->get(['id', 'ruin_id', 'url']);

        foreach ($links as $link) {
            DB::table('ruins')->where('id', $link->ruin_id)->update([
                'tripadvisor' => $link->url,
            ]);

            DB::table('links')->where('id', $link->id)->delete();
        }
    }
};
