<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('limits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('portfolio_id')->unsigned();
            $table->foreign('portfolio_id')->references('id')->on('portfolios')->onDelete('cascade');
            $table->string('type');
            $table->integer('order')->nullable();
            $table->float('value');
            $table->date('date')->nullable();
            $table->boolean('email')->default(false);
            $table->softDeletes();
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
        Schema::dropIfExists('limits');
    }
}
