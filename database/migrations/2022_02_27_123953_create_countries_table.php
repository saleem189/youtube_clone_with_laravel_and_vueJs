<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->string('iso3');
            $table->string('iso2');
            $table->bigInteger('numeric_code');
            $table->string('capital');
            $table->string('currency_name');
            $table->string('currency_symbol');
            $table->string('region');
            $table->string('native')->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->string('emoji');
            $table->string('emojiU');
            $table->json('timezones')->nullable();
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
        Schema::dropIfExists('countries');
    }
}
