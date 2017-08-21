<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCheckedToStock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stocks', function(Blueprint $table) {
            $table->boolean('checked')->nullable()->default(false)->after('industry_id');
            $table->integer('checked_by')->nullable()->after('checked');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stocks', function(Blueprint $table) {
            $table->dropColumn('checked');
            $table->dropColumn('checked_by');
        });
    }
}
