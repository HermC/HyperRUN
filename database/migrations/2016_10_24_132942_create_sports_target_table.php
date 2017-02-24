<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportsTargetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sports_target', function (Blueprint $table) {
            $table->integer('userid');
            $table->dateTime('time');
            $table->enum('type', ['steps', 'distance', 'calorie']);
            $table->double('target');
//            $table->bigInteger('actual');
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
        Schema::drop('sports_target');
    }
}
