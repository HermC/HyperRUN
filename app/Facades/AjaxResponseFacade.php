<?php
/**
 * Created by PhpStorm.
 * User: Hermit
 * Date: 2016/10/24
 * Time: 20:00
 */

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class AjaxResponseFacade extends Facade
{
    protected static function getFacadeAccessor() {
        return 'AjaxResponseService';
    }
}