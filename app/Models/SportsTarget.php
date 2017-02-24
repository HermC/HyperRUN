<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SportsTarget extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'sports_target';

    protected $casts = [
        'target' => 'double',
        'userid' => 'integer'
    ];
}
