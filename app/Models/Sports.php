<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sports extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'sports';

    protected $casts = [
        'steps' => 'integer',
        'distance' => 'double',
        'calorie' => 'double',
        'userid' => 'integer'
    ];
}
