<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thumb extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'thumbs';

    protected $casts = [
        'dynamicid' => 'integer'
    ];
}
