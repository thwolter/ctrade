<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetadataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metadata', function (Blueprint $table) {
            $table->increments('id');
            $table->string('symbol');
            $table->integer('name_id');
            $table->integer('currency_id');
            $table->integer('provider_id');
            $table->integer('database_id')->nullable();
            $table->integer('wkn_id')->nullable();
            $table->integer('isin_id')->nullable();
            $table->integer('sector_id')->nullable();
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
        Schema::dropIfExists('metadata');
    }
}
