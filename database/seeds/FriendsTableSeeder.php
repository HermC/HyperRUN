<?php

use Illuminate\Database\Seeder;

class FriendsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('friends')->insert(
            array(
                [
                    'userid' => 1,
                    'friendid' => 2
                ],
                [
                    'userid' => 1,
                    'friendid' => 3
                ],
                [
                    'userid' => 1,
                    'friendid' =>4
                ]
            )
        );
    }
}
