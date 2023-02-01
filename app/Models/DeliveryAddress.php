<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class DeliveryAddress extends Model
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
        'mobile'
    ];

    public static function deliveryAddresses()
    {
        $deliveryAddresses = DeliveryAddress::where('user_id',Auth::user()->id)->get()->toArray();

        return $deliveryAddresses;
    } 
}
