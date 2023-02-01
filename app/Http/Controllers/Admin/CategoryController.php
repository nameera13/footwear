<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Section;
use Image;

class CategoryController extends Controller
{
    
    public function categories(Request $request)
    {
        $categories= Category::with(['section','parentcategory'])->get()->toarray();
        return view('admin.category.categories')->with(compact(['categories']));
    }

    
    public function create()
    {
        $categories = array();
        $getcategories = array();
        $sections = Section::get()->toArray();
        return view('admin.category.add')->with(compact(['sections']));
    }

    
    public function store(Request $request)
    {
        $request->validate([
                'category_name' => 'required',
                'section_id' => 'required',
                'parent_id' => 'nullable',
                // 'category_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'url' => 'required',
            ]);

        // Category::create($request->all());
        $category_discount= $request->category_discount;
        if($category_discount=="")
        {
            $category_discount=0;
        }

        if($request->hasFile('category_image')){
            $image_tmp = $request->file('category_image');
            if ($image_tmp->isValid()) {
                // Get Image Extension
                $extension = $image_tmp->getClientOriginalExtension();

                // Generate New Image Name
                $imageName = rand(111,99999).'.'.$extension;
                $imagePath = 'uploads/image/category/'.$imageName;

                // Upload Image
                Image::make($image_tmp)->save($imagePath);
                $category_image = $imageName;
            }
        
        }
        else{
            $category_image = "";
        }

        Category::insert([
            'category_name' => ucfirst($request->category_name),
            'section_id' => $request->section_id,
            'parent_id' => $request->parent_id,
            'category_image' => $category_image,
            'category_discount' =>$category_discount,
            'description' =>$request->description,
            'url' =>$request->url,
            'meta_title' =>$request->meta_title,
            'meta_description' =>$request->meta_description,
            'meta_keywords' =>$request->meta_keywords,

        ]);


        return redirect()->route('categories')->with('message','Category Created Successfully!');

    }

    
    public function edit($id)
    {
        $categories=Category::find($id);
        $sections = Section::get()->toArray();
        $getcategories = Category::with('subcategories')->where(['parent_id'=>0, 'section_id'=>$categories['section_id']])->get()->toArray();
        if($categories)
        {
            return view('admin.category.edit',compact(['categories','sections','getcategories']));
        }
        else
        {
            return back()->with('message','Data Not Found');
        }
    }

    
    /*------ ajax category level ------*/

    public function appendCategoryLevel(Request $request)
    {
        if($request->ajax()){
            $data = $request->all(); 
            $getcategories = Category::with('subcategories')->where(['parent_id'=>0, 'section_id'=>$data['section_id']])->get()->toArray();
         
            return view('admin.category.append_categories_level')->with(compact('getcategories'));
        }
    }


    
    public function update(Request $request)
    {
       
        $category_id = $request->category_id; 

        $request->validate(
            [
                'category_name' => 'required',
                'section_id' => 'required',
                'parent_id' => 'nullable',
                'url' => 'required',
            ],

            [
                'category_name.required' => 'The category name filed is required',
                'section_id.required' => 'The section name filed is required',
                'category_discount.required' => 'The category discount filed is required',
                'url.required' => 'The URL filed is required',

            ]
        );

        $categories = Category::find($category_id);

            if($request->hasFile('category_image')){
                $image_tmp = $request->file('category_image');
                if ($image_tmp->isValid()) {
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();

                    // Generate New Image Name
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'uploads/image/category/'.$imageName;

                    // Upload Image
                    Image::make($image_tmp)->save($imagePath);
                    $categories->category_image = $imageName;
                }
            
            }
            
        $categories->category_name = ucfirst($request->category_name);
        $categories->section_id = $request->section_id;
        $categories->parent_id = $request->parent_id;
        $categories->category_discount = $request->category_discount;
        $categories->description = $request->description;
        $categories->url = $request->url;
        $categories->meta_title = $request->meta_title;
        $categories->meta_description = $request->meta_description;
        $categories->meta_keywords = $request->meta_keywords;
        $categories->save();


        return redirect()->route('categories')->with('message','Category Updated Successfully!');
   
    }

    public function updateCategoryStatus(Request $request)
    {   
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die; 
            if($data['status']=="active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Category::where('id',$data['category_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'category_id'=>$data['category_id']]);
        }
    }

    
    public function destroy($id)
    {
        Category::where('id',$id)->delete();
        return redirect()->back()->with('message','Category has been deleted Successfully!');
    }
    

     /*------ Delete category Image ------*/

    public function deleteCategoryImage($id)
    {
        // Get Category Image
        $categoryImage = Category::select('category_image')->where('id',$id)->first();

        // Get Category Image Path
        $category_image_path = 'uploads/image/category/';

        // Delete Category Image From category_image folder if exists
        if(file_exists($category_image_path.$categoryImage->category_image)){
            unlink($category_image_path.$categoryImage->category_image);
        }

        // Delete Category image from category folder
        Category::where('id',$id)->update(['category_image'=>'']);
        return redirect()->back()->with('message','Category Image has been deleted successfully!');

    }
}
