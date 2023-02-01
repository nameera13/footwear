<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsAttributes extends Model
{
    use HasFactory;

    protected $fillable =[
        'product_id',
        'size',
        'price',
        'stock',
        'sku',
        'status'
    ];

    public static function isStockAvailable($product_id,$size)
    {
        $getProductStock = ProductsAttributes::select('stock')->where(['product_id'=>$product_id,'size'=>$size])->first();
        
        return $getProductStock->stock;
    }
}
