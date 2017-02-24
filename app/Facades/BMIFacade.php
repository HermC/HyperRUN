<?php
/**
 * Created by PhpStorm.
 * User: Hermit
 * Date: 2016/11/26
 * Time: 16:42
 */

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class BMIFacade extends Facade
{
    protected static function getFacadeAccessor() {
        return 'BMI';
    }
}