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
        // Continents Table
        Schema::create('continents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 16)->index();
            $table->string('code', 2);
            $table->boolean('active')->default(false);
        });

        // Continents Locale Table
        Schema::create('continents_locale', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('continent_id');
            $table->string('name', 255)->nullable();
            $table->string('alias', 255)->nullable();
            $table->string('abbr', 16)->nullable();
            $table->string('full_name', 255)->nullable();
            $table->string('locale', 6)->nullable();
            $table->unique(['continent_id', 'locale']);
            $table->foreign('continent_id')->references('id')->on('continents')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('continents_locale');
        Schema::drop('continents');
    }
};
