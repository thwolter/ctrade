<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortfoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('category_id')->nullable();
            $table->float('cash');
            $table->integer('currency_id');
            $table->float('confidence')->default(0.95);
            $table->integer('period')->default(1);
            $table->integer('mailing')->default(7);
            $table->integer('threshold')->default(0);
            $table->float('limit')->default(0);
            $table->boolean('limit_abs')->default(true);
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
        Schema::dropIfExists('portfolios');
    }
}
