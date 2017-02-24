<?php

use Illuminate\Database\Seeder;

class SleepTableSeeder extends Seeder
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

        for($i=0;$i<5;$i++){

            for($j=0;$j<14;$j++){
                $tmp = [
                    'userid' => 11,
                    'time' => date_format($date, 'Y-m-d H:i:s'),
                    'value' => random_int(0, 16)
                ];

                $date = date_add($date, date_interval_create_from_date_string("30 minutes"));

                array_push($array, $tmp);
            }

//            $date = date_add($date, date_interval_create_from_date_string("14 hours"));
            for($j=0;$j<28;$j++){
                $tmp = [
                    'userid' => 11,
                    'time' => date_format($date, 'Y-m-d H:i:s'),
                    'value' => random_int(16, 100)
                ];

                $date = date_add($date, date_interval_create_from_date_string("30 minutes"));

                array_push($array, $tmp);
            }

            for($j=0;$j<6;$j++){
                $tmp = [
                    'userid' => 11,
                    'time' => date_format($date, 'Y-m-d H:i:s'),
                    'value' => random_int(0, 16)
                ];

                $date = date_add($date, date_interval_create_from_date_string("30 minutes"));

                array_push($array, $tmp);
            }
        }

        DB::table('sleep')->insert($array);
    }
}
