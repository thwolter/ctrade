<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatasetablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datasetables', function (Blueprint $table) {
            //$table->increments('id');
            $table->integer('dataset_id');
            $table->integer('datasetable_id');
            $table->string('datasetable_type');
            $table->primary(['dataset_id', 'datasetable_id']);
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
        Schema::dropIfExists('datasetables');
    }
}
