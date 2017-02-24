<?php
/**
 * Created by PhpStorm.
 * User: Hermit
 * Date: 2016/11/16
 * Time: 14:20
 */

namespace App\Services;

class BMIService
{

    public function tips($height, $weight) {
        $target_weight = $this->targetWeight($height);

        $value = [18.4, 23.9, 27.9, PHP_INT_MAX];
        $type = ['偏瘦', '正常', '过重', '肥胖'];

        $height = $height / 100;

        $bmi = $weight / ($height * $height);

        $tips = [
            'value' => $bmi,
            'target_weight' => $target_weight
        ];

        for($i=0;$i<sizeof($value);$i++){
            if($bmi <= $value[$i]){
                $tips['tips'] = $type[$i];
                break;
            }
        }

        return $tips;
    }

    public function targetWeight($height) {
        return ($height - 100) * 0.9;
    }
}