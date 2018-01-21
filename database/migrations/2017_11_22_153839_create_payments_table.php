<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('portfolio_id')->unsigned();
            $table->foreign('portfolio_id')->references('id')->on('portfolios')->onDelete('cascade');
            $table->integer('position_id')->nullable()->unsigned();
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
            $table->integer('payment_id')->nullable();
            $table->enum('type',['fees', 'deposit', 'withdrawal', 'buy', 'sell']);
            $table->integer('exchange_id')->nullable();
            $table->float('amount');
            $table->dateTime('executed_at');
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
        Schema::dropIfExists('payments');
    }
}
