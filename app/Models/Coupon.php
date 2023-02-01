<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'coupon_option',
        'coupon_code',
        'categories',
        'users',
        'coupon_type',
        'amount_type',
        'amount',
        'expiry_date',
        'status'
    ];
}
