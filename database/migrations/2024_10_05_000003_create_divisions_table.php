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
        // Divisions Table
        Schema::create('divisions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('country_id');
            $table->string('name', 255);
            $table->string('full_name', 255)->nullable();
            $table->string('code', 64)->nullable();
            $table->boolean('has_city')->default(false);
            $table->boolean('active')->default(false);

            // Indexes
            $table->unique(['country_id', 'name']);
            $table->foreign('country_id')->references('id')->on('countries')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });

        // Divisions Locale Table
        Schema::create('divisions_locale', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('division_id');
            $table->string('name', 255);
            $table->string('abbr', 16)->nullable();
            $table->string('alias', 255)->nullable();
            $table->string('full_name', 255)->nullable();
            $table->string('locale', 6)->nullable();
            $table->unique(['division_id', 'locale']);
            $table->foreign('division_id')->references('id')->on('divisions')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('divisions_locale');
        Schema::drop('divisions');
    }
};
