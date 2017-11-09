<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->string('first_name')->nullable();
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->json('settings')->nullable();
            $table->boolean('verified')->default(false);
            $table->string('email_new')->nullable();
            $table->string('avatar')->nullable();
            $table->string('email_token')->nullable();
            $table->rememberToken();
            $table->dateTime('email_token_expires_at')->nullable();
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
        Schema::dropIfExists('users');
    }
}
