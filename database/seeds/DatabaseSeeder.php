<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(FriendsTableSeeder::class);
        $this->call(FriendRequestsTableSeeder::class);
        $this->call(WeightTableSeeder::class);
        $this->call(SportsTableSeeder::class);
    }
}
