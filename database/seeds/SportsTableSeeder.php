<?php

use Illuminate\Database\Seeder;

class SportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = date_create("2016-11-29 00:00:00");
        $array = array();

        for($i=0;$i<144;$i++){
            $tmp = [
                'userid' => 11,
                'time' => date_format($date, 'Y-m-d H:i:s'),
                'steps' => random_int(300, 10000),
                'distance' => random_int(1000, 2000),
                'calorie' => random_int(1000, 10000)
            ];

            $date = date_add($date, date_interval_create_from_date_string("1 hours"));

            array_push($array, $tmp);
        }

        DB::table('sports')->insert($array);
    }
}
