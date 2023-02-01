<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsFilter extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'cat_ids',
        'filter_name',
        'filter_column',
        'status'
    ];

    public static function getFilterName($category_id)
    {
        $getFilterName = ProductsFilter::select('filter_name')->where('id',$category_id)->first();
        return $getFilterName->filter_name;
    }

    public function filter_values()
    {
        return $this->hasMany('App\Models\ProductsFilterValue','filter_id');
    }

    public static function productFilters()
    {
        $productFilters = ProductsFilter::with('filter_values')->where('status',1)->get()->toArray();
        return $productFilters;
    }

    public static function filterAvailable($filter_id,$category_id)
    {
        $filterAvailable = ProductsFilter::select('cat_ids')->where(['id'=>$filter_id,'status'=>1])->first()->toArray();
        $catIdsArr = explode(",",$filterAvailable['cat_ids']);
        if(in_array($category_id,$catIdsArr)){
            $available = "Yes";
        }else{
            $available = "No";
        }
        return $available;
    }

    public static function getSizes($url)
    {
        $categoryDetails = Category::categoryDetails($url);
        $getProductIds = Product::select('id')->whereIn('category_id',$categoryDetails['catIds'])->pluck('id')->toArray();
        $getProductSizes = ProductsAttributes::select('size')->whereIn('product_id',$getProductIds)->pluck('size')->toArray();
        // echo "<pre>"; print_r($getProductSizes); die;
        return $getProductSizes;
    }

    public static function getColors($url)
    {
        $categoryDetails = Category::categoryDetails($url);
        $getProductIds = Product::select('id')->whereIn('category_id',$categoryDetails['catIds'])->pluck('id')->toArray();
        $getProductColors = Product::select('product_color')->whereIn('id',$getProductIds)->groupBy('product_color')->pluck('product_color')->toArray();
        //  echo "<pre>"; print_r($getColors); die;
         return $getProductColors;
    }
}
