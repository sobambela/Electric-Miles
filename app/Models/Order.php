<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'exptected_delivery_time',
        'delivery_address',
        'billing_address',
        'status',
    ];

    public function items(){
        return $this->hasMany(OrderItems::class);
    }
}
