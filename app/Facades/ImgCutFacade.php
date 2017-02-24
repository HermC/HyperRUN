<?php
/**
 * Created by PhpStorm.
 * User: Hermit
 * Date: 2016/11/4
 * Time: 16:15
 */

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class ImgCutFacade extends Facade
{
    protected static function getFacadeAccessor() {
        return 'ImgCutService';
    }
}