<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Cities Table
        Schema::create('cities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('division_id')->index()->nullable();
            $table->string('name', 255);
            $table->string('full_name', 255)->nullable();
            $table->string('code', 64)->nullable();
            $table->string('iana_timezone', 255)->nullable();
            $table->boolean('active')->default(false);

            // Indexes
            $table->index(['country_id', 'division_id', 'name']);
            $table->foreign('country_id')->references('id')->on('countries')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('division_id')->references('id')->on('divisions')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });

        // Cities Locale Table
        Schema::create('cities_locale', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('city_id');
            $table->string('name', 255);
            $table->string('alias', 255)->nullable();
            $table->string('full_name', 255)->nullable();
            $table->string('locale', 6)->nullable();
            $table->unique(['city_id', 'locale']);
            $table->foreign('city_id')->references('id')->on('cities')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cities_locale');
        Schema::drop('cities');
    }
};
