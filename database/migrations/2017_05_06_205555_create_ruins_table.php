<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRuinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ruins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 250);
            $table->string('slug', 250);
            $table->string('period')->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->text('information')->nullable();
            $table->string('image')->nullable();
            $table->string('tripadvisor')->nullable();
            $table->string('foursquare')->nullable();
            $table->boolean('official_site')->default(0);
            $table->integer('city_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ruins');
    }
}
