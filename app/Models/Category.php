<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable =[

        'parent_id', 
        'section_id',
        'category_name',
        'category_image',
        'category_discount',
        'description',
        'url',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status',

    ];

    public function section()
    {
        return $this->belongsTo('App\Models\Section','section_id')->select('id','section_name');
    }

    public function parentcategory()
    {
        return $this->belongsTo('App\Models\Category','parent_id')->select('id','category_name');
    }

    public function subcategories()
    {
        return $this->hasMany('App\Models\Category','parent_id')->where('status',1);
    }

    public static function categoryDetails($url)
    {
        $categoryDetails = Category::select('id','parent_id','category_name','description','url')->with(['subcategories'=>function($query){
            $query->select('id','parent_id','category_name','url');
        }])->where('url',$url)->first()->toArray();

        $catIds = array();
        $catIds[] = $categoryDetails['id'];

        if($categoryDetails['parent_id']==0){
            $breadcrumbs = '<span><a href="'.url($categoryDetails['url']).'" title="">'.$categoryDetails['category_name'].'</a></span>';
            
        }else{
            $parentCategory = Category::select('category_name','url')->where('id',
            $categoryDetails['parent_id'])->first()->toArray();
            $breadcrumbs = '<span><a href="'.url($categoryDetails['url']).'" title="">'.$parentCategory['category_name'].'</a>›</span><span><a href="'.url($categoryDetails['url']).'" title="">'.$categoryDetails['category_name'].'</a></span>';

        }

        foreach ($categoryDetails['subcategories'] as $key => $subcat) {
           $catIds[] = $subcat['id'];
        }
        $resp = array('catIds'=>$catIds,'categoryDetails'=>$categoryDetails,'breadcrumbs'=>$breadcrumbs);
        return $resp;
    }

    public static function getCategoryName($category_id)
    {
        $getCategoryName = Category::select('category_name')->where('id',$category_id)->first();
        return $getCategoryName->category_name;
    }
}
