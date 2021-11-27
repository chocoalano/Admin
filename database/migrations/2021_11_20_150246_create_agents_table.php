<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('ip',100);
            $table->string('version',100)->nullable();
            $table->string('city',100)->nullable();
            $table->string('region',100)->nullable();
            $table->string('region_code',100)->nullable();
            $table->string('country',100)->nullable();
            $table->string('country_name',100)->nullable();
            $table->string('country_code',100)->nullable();
            $table->string('country_code_iso3',100)->nullable();
            $table->string('country_capital',100)->nullable();
            $table->string('country_tld',100)->nullable();
            $table->string('continent_code',100)->nullable();
            $table->string('in_eu',100)->nullable();
            $table->string('postal',100)->nullable();
            $table->string('latitude',100)->nullable();
            $table->string('longitude',100)->nullable();
            $table->string('timezone',100)->nullable();
            $table->string('utc_offset',100)->nullable();
            $table->string('country_calling_code',100)->nullable();
            $table->string('currency',100)->nullable();
            $table->string('currency_name',100)->nullable();
            $table->string('languages',100)->nullable();
            $table->string('country_area',100)->nullable();
            $table->string('country_population',100)->nullable();
            $table->string('asn',100)->nullable();
            $table->string('org',100)->nullable();
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
        Schema::dropIfExists('agents');
    }
}
