<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\User', 10)->create();

        DB::table('users')->insert(
            array(
                [
                    'name' => 'HermC',
                    'email' => 'yzy627@126.com',
                    'password' => bcrypt('123456'),
                    'remember_token' => str_random(10),
                ]
            )
        );
    }
}
