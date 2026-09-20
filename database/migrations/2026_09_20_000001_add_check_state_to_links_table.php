<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('links', function (Blueprint $table) {
            $table->string('last_status')->nullable()->after('language');
            $table->string('last_reason')->nullable()->after('last_status');
            $table->timestamp('last_checked_at')->nullable()->after('last_reason');
        });
    }

    public function down(): void
    {
        Schema::table('links', function (Blueprint $table) {
            $table->dropColumn(['last_status', 'last_reason', 'last_checked_at']);
        });
    }
};
