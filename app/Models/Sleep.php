<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sleep extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'sleep';

    protected $casts = [
        'value' => 'double',
        'userid' => 'integer'
    ];
}
