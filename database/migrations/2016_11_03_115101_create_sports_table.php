<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sports', function (Blueprint $table) {
//            $table->increments('id');
            $table->integer('userid');
            $table->dateTime('time');
            $table->double('steps');
            $table->double('distance');
            $table->double('calorie');
            $table->timestamps();
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sports');
    }
}
