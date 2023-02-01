<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'firstname',
        'lastname',
        'address',
        'city',
        'state',
        'country',
        'pincode',
        'mobile',
        'email',
        'shipping_charges',
        'coupon_code',
        'coupon_amount',
        'order_status',
        'payment_method',
        'payment_gateway',
        'grand_total'
    ];

    public function orders_products()
    {
        return $this->hasMany('App\Models\OrdersProduct','order_id');
    }
}
