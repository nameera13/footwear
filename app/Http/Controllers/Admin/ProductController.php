<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsAttributes;
use App\Models\ProductsImage;
use App\Models\ProductsFilter;
use Image;


class ProductController extends Controller
{
    
    public function products()
    {
        $products = Product::with(['section'=>function($query){
            $query->select('id','section_name');
        },'category'=>function($query){
            $query->select('id','category_name');
        }])->get()->toArray();
        return view('admin.product.products')->with(compact('products'));
    }

    

   /*------ Update Product Status ------*/
    public function updateProductStatus(Request $request)
    {   
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die; 
            if($data['status']=="active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Product::where('id',$data['product_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'product_id'=>$data['product_id']]);
        }
    }


    /*------ Add Edit Product ------*/

    public function addEditProduct(Request $request, $id=null)
    {
        if($id==""){

            $title="Add Product";
            $product = new Product;
            $message = "Product Added Successfully!";
        }else{

            $title = "Edit Product";
            $product = Product::find($id);
            $message = "Product Updated Successfully!";
        }

        if($request->isMethod('POST')){ 
            $data = $request->all();
            // echo "<pre>"; print_r($data); die ;
            $request->validate(
                [
                    'category_id' => 'required',
                    'product_name' => 'required',
                    'product_code' => 'required',
                    'product_price' =>'required|numeric',
                    'product_color' => 'required',
                ],

                [
                    'category_id.required' => 'category is required',
                    'product_name.required' => ' Product Name  is required',
                    'product_code.required' => ' Product Code  is required',
                    'product_price.required' => ' Product Price  is required',
                    'product_price.numeric' => 'Valid Product Price is required',
                    'product_color.required' => ' Product Color  is required',
                ]
            );
             

        /*------ Upload Product Image after Resize small: 250x250 medium: 500x500 large: 1000x1000 ------*/
            
            if($request->hasFile('product_image')){
                $image_tmp = $request->file('product_image');
                if($image_tmp->isValid()){
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate New Image Name
                    $imageName = rand(111,99999).'.'.$extension;
                    $largeImagePath = 'uploads/image/product/large/'.$imageName;
                    $mediumImagePath = 'uploads/image/product/medium/'.$imageName;
                    $smallImagePath = 'uploads/image/product/small/'.$imageName;
                    // Upload the Large, Medium and Small Images after Resize
                    Image::make($image_tmp)->resize(1000,1000)->save($largeImagePath);
                    Image::make($image_tmp)->resize(500,500)->save($mediumImagePath);
                    Image::make($image_tmp)->resize(250,250)->save($smallImagePath);

                    // Insert Image Name in product Table
                    $product->product_image = $imageName;
                }
            }


             /*------ Upload Product Video ------*/

            if($request->hasFile('product_video')){
                $video_tmp = $request->file('product_video');
                if($video_tmp->isValid()){
                    // Upload Video in Videos Folder
                    $extension = $video_tmp->getClientOriginalExtension();
                    $videoName = rand(111,99999).'.'.$extension;
                    $videoPath = 'uploads/video/product/';
                    $video_tmp->move($videoPath,$videoName);
                    // Insert Video Name in Product Table
                    $product->product_video = $videoName;
                }
            }

            if (empty($data['product_discount'])) {
                $data['product_discount'] = 0;
            }
            if (empty($data['product_weight'])) {
                $data['product_weight'] = 0;
            }
            

            $categoryDetails = Category::find($data['category_id']);
            $product->section_id = $categoryDetails['section_id'];
            $product->category_id = $data['category_id'];
            $product->group_code = $data['group_code'];

            $productFilters = ProductsFilter::productFilters();
            foreach($productFilters as $filter) {
                //  $data[$filter['filter_column']];
                $filterAvailable = ProductsFilter::filterAvailable($filter['id'],$data['category_id']);
                if($filterAvailable=="Yes"){
                    if(isset($filter['filter_column']) && $data[$filter['filter_column']]){
                        $product->{$filter['filter_column']} = $data[$filter['filter_column']];
                    }
                }
            }
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];
            $product->product_weight = $data['product_weight'];
            $product->description = $data['description'];
            $product->meta_title = $data['meta_title'];
            $product->meta_description = $data['meta_description'];
            $product->meta_keywords = $data['meta_keywords'];

            if(!empty($data['is_featured'])){
                $product->is_featured = $data['is_featured'];
            }else{
                $product->is_featured = "No";
            }

            if(!empty($data['is_bestseller'])){
                $product->is_bestseller = $data['is_bestseller'];
            }else{
                $product->is_bestseller = "No";
            }
            
            $product->save();

            return redirect()->route('products')->with('message',$message);

        }

        $categories = Section::with('categories')->get()->toArray();
        return view('admin.product.add_edit')->with(compact('title','product','categories'));
    }

    
    public function destroy($id)
    {
        Product::where('id',$id)->delete();
        $message = "Product has been deleted Successfully!";
        return redirect()->back()->with('message',$message);
    }


     /*------ Delete Product Image ------*/

    public function deleteProductImage($id)
    {
        $productImage = Product::select('product_image')->where('id',$id)->first();

        // Get Product Image Paths
        $small_image_path = 'uploads/image/product/small/';
        $medium_image_path = 'uploads/image/product/medium/';
        $large_image_path = 'uploads/image/product/large/';

        // Delete Product small image if exists in small folder
        if(file_exists($small_image_path.$productImage->product_image)){
            unlink($small_image_path.$productImage->product_image);
        }

        // Delete Product small image if exists in small folder
        if(file_exists($medium_image_path.$productImage->product_image)){
            unlink($medium_image_path.$productImage->product_image);
        }

        // Delete Product small image if exists in small folder
        if(file_exists($large_image_path.$productImage->product_image)){
            unlink($large_image_path.$productImage->product_image);
        }

        // Delete Product Image from products table
        Product::where('id',$id)->update(['product_image'=>'']);

        $message = "Product Image has been deleted Successfully!";
        return redirect()->back()->with('message',$message);

    }


    /*------ Delete Product Video ------*/

    public function deleteProductVideo($id)
    {
        $productVideo = Product::select('product_video')->where('id',$id)->first();

        // Get Product Video Path
        $product_video_path = 'uploads/video/product/';

        // Delete Product Video from product folder if exists
        if(file_exists($product_video_path.$productVideo->product_video)){
            unlink($product_video_path.$productVideo->product_video);
        }

        // Delete Product Video from Product Table
        Product::where('id',$id)->update(['product_video'=>'']);

        $message = "Product Video has been deleted Successfully!";
        return redirect()->back()->with('message',$message);

    }


     /*------ Add Attribute ------*/

    public function addAttributes(Request $request,$id)
    {
        $product = Product::select('id','product_name','product_code','product_color','product_price','product_image')->with('attributes')->find($id);
        // $product = json_decode(json_encode($product),true);
        // dd($product);
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>";print_r($data);die;
            foreach ($data['sku'] as $key => $value) {
                if (!empty($value)) {

                    // SKU duplicate check
                    $skuCount = ProductsAttributes::where('sku',$value)->count();
                    if($skuCount>0){
                        return redirect()->back()->with('error_message','SKU already exists! Please add another SKU!');
                    }

                    // Size duplicate check
                    $sizeCount = ProductsAttributes::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
                    if($sizeCount>0){
                        return redirect()->back()->with('error_message','Size already exists! Please add another Size!');
                    }

                    $attribute = new ProductsAttributes;
                    $attribute->product_id = $id;
                    $attribute->sku = $value;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->save();
                }
            }

            return redirect()->back()->with('message','Product Attributes has been added Successfully!');
            
        }
        return view('admin.attributes.add_edit')->with(compact('product'));
    }

    
     /*------ Update Attribute Status ------*/

    public function updateAttributeStatus(Request $request)
    {   
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die; 
            if($data['status']=="active"){
                $status = 0;
            }else{
                $status = 1;
            }
            ProductsAttributes::where('id',$data['attribute_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'attribute_id'=>$data['attribute_id']]);
        }
    }

     /*------ Edit Attributes ------*/

    public function editAttributes(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            foreach ($data['attributeId'] as $key => $attribute) {
                if(!empty($attribute)){
                    ProductsAttributes::where(['id'=>$data['attributeId'][$key]])->update(['price'=>$data['price'][$key],'stock'=>$data['stock'][$key]]);
                }
            }
            return redirect()->back()->with('message','Product Attributes has been updated Successfully!');
        }
    }


     /*------ Add Image ------*/

    public function addImages(Request $request, $id)
    {
        $product = Product::select('id','product_name','product_code','product_color','product_price','product_image')->with('images')->find($id);
        
        if($request->isMethod('post')){
            $data = $request->all();

             /*------ Image ------*/

            if($request->hasFile('image')){
                $images = $request->file('image');
                // echo"<pre>";print_r($imageName); die;
                foreach ($images as $key => $image) {
                  // Generate Temp Image 
                  $image_tmp = Image::make($image); 
                  // Get Image Name
                  $image_name = $image->getClientOriginalName(); 
                  // Get Image Extension
                  $extension = $image->getClientOriginalExtension();
                  // Generate New Image Name
                  $imageName = $image_name.rand(111,99999).'.'.$extension;
                  $largeImagePath = 'uploads/image/product/large/'.$imageName;
                  $mediumImagePath = 'uploads/image/product/medium/'.$imageName;
                  $smallImagePath = 'uploads/image/product/small/'.$imageName;
                  // Upload the Large, Medium and Small Images after Resize
                  Image::make($image_tmp)->resize(1000,1000)->save($largeImagePath);
                  Image::make($image_tmp)->resize(500,500)->save($mediumImagePath);
                  Image::make($image_tmp)->resize(250,250)->save($smallImagePath);

                  // Insert Image Name in product Table
                  $image = new ProductsImage;
                  $image->image = $imageName;
                  $image->product_id = $id;
                  $image->save();
                }
            }
            return redirect()->back()->with('message','Product Image has been added Successfully!');
        }
        return view('admin.images.add_images')->with(compact('product')); 
   
    }


     /*------ Update Image Status ------*/

    public function updateImageStatus(Request $request)
    {   
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die; 
            if($data['status']=="active"){
                $status = 0;
            }else{
                $status = 1;
            }
            ProductsImage::where('id',$data['image_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'image_id'=>$data['image_id']]);
        }
    }

     /*------ Delete Image ------*/

    public function deteteImage($id)
    {
        $productImage = ProductsImage::select('image')->where('id',$id)->first();

        // Get Product Image Paths
        $small_image_path = 'uploads/image/product/small/';
        $medium_image_path = 'uploads/image/product/medium/';
        $large_image_path = 'uploads/image/product/large/';

        // Delete Product small image if exists in small folder
        if(file_exists($small_image_path.$productImage->image)){
            unlink($small_image_path.$productImage->image);
        }

        // Delete Product small image if exists in small folder
        if(file_exists($medium_image_path.$productImage->image)){
            unlink($medium_image_path.$productImage->image);
        }

        // Delete Product small image if exists in small folder
        if(file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path.$productImage->image);
        }

        // Delete Product Image from products table
        ProductsImage::where('id',$id)->delete();

        $message = "Product Image has been deleted Successfully!";
        return redirect()->back()->with('message',$message);

    }

}

