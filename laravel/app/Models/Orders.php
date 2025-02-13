<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';

    protected $guarded = [];

    public function orderitems(){
        return $this->hasMany(OrderItems::class, 'order_id');
    }
}
