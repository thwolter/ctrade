<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->integer('portfolio_id')->unsigned();
            $table->foreign('portfolio_id')->references('id')->on('portfolios')->onDelete('cascade');
            $table->integer('transaction_type_id');
            $table->integer('instrumentable_id')->nullable();
            $table->string('instrumentable_type')->nullable();
            $table->float('amount');
            $table->float('price')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}