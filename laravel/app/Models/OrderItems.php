<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    protected $table = 'order_items';

    protected $guarded = [];

    public function order(){
        return $this->belongsTo(Orders::class, 'order_id');
    }

    public function menu(){
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
