<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weight extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'weight';

    protected $casts = [
        'actual' => 'double',
        'userid' => 'integer'
    ];
}
