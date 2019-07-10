<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    public function meta() {
        return $this->hasMany('App\OrderMeta', 'order_id', 'id');
    }

    public function points() {
        return $this->hasMany('App\OrderPoint', 'order_id', 'id');
    }
}
