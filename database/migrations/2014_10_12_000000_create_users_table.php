<?php

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
            $table->string('email')->unique();
            $table->string('name')->unique();
            $table->string('password', 60);
            $table->dateTime('birthday')->nullable();
            $table->string('sex', 10)->default('female');
            $table->string('synopsis', 10000)->nullable();
            $table->string('portrait', 60)->default('/img/default.jpg');
            $table->integer('level')->default(1);
            $table->integer('exp')->default(0);
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
