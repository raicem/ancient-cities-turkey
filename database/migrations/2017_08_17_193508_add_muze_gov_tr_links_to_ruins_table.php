<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMuzeGovTrLinksToRuinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ruins', function (Blueprint $table) {
            $table->string('official_site_tr')->nullable();
            $table->string('official_site_en')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ruins', function (Blueprint $table) {
            $table->dropColumn('official_site_tr');
            $table->dropColumn('official_site_en');
        });
    }
}
