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
        // Countries Table
        Schema::create('countries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('continent_id');
            $table->string('name', 255);
            $table->string('full_name', 255)->nullable();
            $table->string('capital', 255)->nullable();
            $table->string('code', 4)->nullable();
            $table->string('code_alpha3', 6)->nullable();
            $table->smallInteger('code_numeric')->nullable();
            $table->string('emoji', 16)->nullable();
            $table->boolean('has_division')->default(0);
            $table->string('currency_code', 3)->nullable();
            $table->string('currency_name', 128)->nullable();
            $table->string('tld', 8)->nullable();
            $table->string('calling_code', 8)->nullable();
            $table->boolean('active')->default(false);

            // Indexes
            $table->unique(['continent_id', 'name']);
            $table->foreign('continent_id')->references('id')->on('continents')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });

        // Countries Locale Table
        Schema::create('countries_locale', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('country_id');
            $table->string('name', 255);
            $table->string('alias', 255)->nullable();
            $table->string('abbr', 16)->nullable();
            $table->string('full_name', 255)->nullable();
            $table->string('currency_name', 255)->nullable();
            $table->string('locale', 6)->nullable();
            $table->unique(['country_id', 'locale']);
            $table->foreign('country_id')->references('id')->on('countries')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('countries_locale');
        Schema::drop('countries');
    }
};
