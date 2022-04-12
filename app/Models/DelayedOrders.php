<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DelayedOrders extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'current_time',
        'exptected_delivery_time'
    ];

    public function order(){
        return $this->hasOne(Order::class, 'id', 'order_id');
    }
}
