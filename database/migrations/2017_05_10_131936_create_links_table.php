<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('links', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ruin_id');
            $table->string('description');
            $table->string('url');
            $table->string('language');
            $table->timestamps();
        });
    }

        public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
