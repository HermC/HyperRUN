<?php

use Illuminate\Database\Seeder;

class FriendRequestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('friend_requests')->insert(
            array(
                [
                    'userid' => 11,
                    'friendid' => 9
                ],
                [
                    'userid' => 11,
                    'friendid' => 10
                ]
            )
        );
    }
}
