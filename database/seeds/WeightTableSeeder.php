<?php

use Illuminate\Database\Seeder;

class WeightTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = date_create("2016-11-01 00:00:00");
        $array = array();

        for($i=0;$i<30;$i++){
            $tmp = [
                'userid' => 11,
                'time' => date_format($date, 'Y-m-d H:i:s'),
//                'target' => random_int(30, 120),
                'actual' => random_int(30, 120)
            ];

            $date = date_add($date, date_interval_create_from_date_string("1 days"));

            array_push($array, $tmp);
        }

        DB::table('weight')->insert($array);
    }
}
