<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Society extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'society';
    protected $primaryKey = 'dynamicid';

    protected $casts = [
        'comment_num' => 'integer',
        'thumb_num' => 'integer',
        'dynamicid' => 'integer',
        'userid' => 'integer'
    ];
}
