<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatasourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datasources', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('provider_id');
            $table->integer('database_id')->nullable();
            $table->string('exchange_id');
            $table->integer('dataset_id');
            $table->boolean('valid')->default(true);
            $table->date('oldest_date')->nullable();
            $table->date('newest_date')->nullable();
            $table->timestamp('refreshed_at')->nullable();
            $table->unique(['provider_id', 'database_id', 'dataset_id']);
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
        Schema::dropIfExists('datasources');
    }
}
