<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ownerid');
            $table->string('title');
            $table->string('type');
            $table->integer('participant_num');
            $table->dateTime('start');
            $table->string('place');
            $table->string('detail');
            $table->timestamps();
            $table->foreign('ownerid')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('activity');
    }
}
