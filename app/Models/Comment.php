<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'comments';
}
