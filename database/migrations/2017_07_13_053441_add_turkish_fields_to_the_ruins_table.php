<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTurkishFieldsToTheRuinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ruins', function (Blueprint $table) {
            $table->string('name_tr', 250)->nullable();
            $table->text('information_tr')->nullable();
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
            $table->dropColumn('name_tr');
            $table->dropColumn('information_tr');
        });
    }
}
