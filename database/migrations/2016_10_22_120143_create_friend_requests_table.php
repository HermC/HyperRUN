<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriendRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friend_requests', function (Blueprint $table) {
            $table->integer('userid');
            $table->integer('friendid');
            $table->timestamps();
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('friendid')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('friend_requests');
    }
}
