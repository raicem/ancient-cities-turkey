<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ruins', function (Blueprint $table) {
            $table->string('official_site_tr')->nullable();
            $table->string('official_site_en')->nullable();
        });
    }

        public function down(): void
    {
        Schema::table('ruins', function (Blueprint $table) {
            $table->dropColumn('official_site_tr');
            $table->dropColumn('official_site_en');
        });
    }
};
