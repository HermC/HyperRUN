<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityParticipateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_participate', function (Blueprint $table) {
//            $table->increments('id');
            $table->integer('activityid');
            $table->integer('userid');
            $table->timestamps();
            $table->foreign('activityid')->references('id')->on('activity')->onDelete('cascade');
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
        Schema::drop('activity_participate');
    }
}
