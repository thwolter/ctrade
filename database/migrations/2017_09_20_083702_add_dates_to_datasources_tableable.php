<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDatesToDatasourcesTableable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('datasources', function (Blueprint $table) {
            $table->date('oldest_date')->nullable()->after('valid');
            $table->date('newest_date')->nullable()->after('oldest_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('datasources', function (Blueprint $table) {
            $table->dropColumn('oldest_date');
            $table->dropColumn('newest_date');
        });
    }
}
