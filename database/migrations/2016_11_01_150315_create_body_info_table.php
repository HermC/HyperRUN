<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBodyInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('body_info', function (Blueprint $table) {
            $table->integer('userid')->unique();
            $table->double('height')->nullable();
            $table->double('weight')->nullable();
            $table->double('run_step')->nullable();
            $table->double('walk_step')->nullable();
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
        Schema::drop('body_info');
    }
}
