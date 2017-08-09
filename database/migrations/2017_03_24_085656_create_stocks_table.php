<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('proposed_name')->nullable();
            $table->string('exchange_id');
            $table->integer('currency_id');
            $table->string('wkn')->nullable();
            $table->string('isin');
            $table->timestamp('checked_at')->nullable();
            $table->integer('sector_id')->nullable();
            $table->integer('industry_id')->nullable();
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
        Schema::dropIfExists('stocks');
    }
}
