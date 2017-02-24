<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocietyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('society', function (Blueprint $table) {
            $table->increments('dynamicid');
            $table->integer('userid');
            $table->string('title', 60);
            $table->string('content', 10000);
            $table->integer('comment_num');
            $table->integer('thumb_num');
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
        Schema::drop('society');
    }
}
