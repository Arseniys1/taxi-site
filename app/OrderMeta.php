<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderMeta extends Model
{
    protected $table = 'order_meta';

    protected $primaryKey = 'order_id';
}
