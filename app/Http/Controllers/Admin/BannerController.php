<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Image;

class BannerController extends Controller
{
    
    public function index()
    {
        $banners = Banner::orderby('id','ASC')->get()->toArray();
        return view('admin.banner.banners',compact('banners'));
    }

    
    public function create()
    {
        return view('admin.banner.add');
    }

    
    public function store(Request $request)
    {

        $request->validate(
            [
                'title' => 'required',
                'link' => 'required',
                'alt'  => 'required'
            ],

            [
                'title.required' => 'The title filled is required',
                'link.required' => 'The link filled is required',
                'alt.required' => 'The Alternate Text filled is required',
                
            ]
        );
        
        /*------ image ------*/

        if($request->hasFile('photo')){
            $image_tmp = $request->file('photo');
            if ($image_tmp->isValid()) {
                // Get Image Extension
                $extension = $image_tmp->getClientOriginalExtension();

                // Generate New Image Name
                $imageName = rand(111,99999).'.'.$extension;
                $imagePath = 'uploads/image/banner/'.$imageName;

                // Upload Image
                Image::make($image_tmp)->resize(1920,720)->save($imagePath);
                $photo = $imageName;
            }
        
        }
        else{
            $category_image = "";
        }

        if($request['type']=="Slider"){
            $width = "1920";
            $height = "720";
        }else if($request['type']=="Fix"){
            $width = "1920";
            $height = "450";
        }

        Banner::insert([
            'title' => $request->title,
            'photo' => $photo,
            'type' => $request->type,
            'link' => $request->link,
            'alt' => $request->alt
        ]);
        
        return redirect()->route('allbanners')->with('message','Banner Created Successfully!');

    }

    

    public function edit($id)
    {
        $banners=Banner::find($id);
        if($banners)
        {
            return view('admin.banner.edit',compact('banners'));
        }
        else
        {
            return back()->with('message','Data Not Found');
        }
    }

    
    public function update(Request $request)
    {
        $banner_id = $request->banner_id; 
        $request->validate(
            [
                'title' => 'required',
                'link' => 'required',
                'alt'  => 'required'
            ],

            [
                'title.required' => 'The title filled is required',
                'link.required' => 'The link filled is required',
                'alt.required' => 'The Alternate Text filled is required',
                
            ]
        );


        
        $banners = Banner::find($banner_id);

             /*------ Image ------*/


            if($request->hasFile('photo')){
                $image_tmp = $request->file('photo');
                if ($image_tmp->isValid()) {
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();

                    // Generate New Image Name
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'uploads/image/banner/'.$imageName;

                    // Upload Image
                    Image::make($image_tmp)->resize(1920,720)->save($imagePath);
                    $banners->photo = $imageName;
                }
            
            }

            if($request['type']=="Slider"){
                $width = "1920";
                $height = "720";
            }else if($request['type']=="Fix"){
                $width = "1920";
                $height = "450";
            }
            
        $banners->title = ucfirst($request->title);
        $banners->type = $request->type;
        $banners->link = $request->link;
        $banners->alt = $request->alt;
        $banners->save();

        return redirect()->route('allbanners')->with('message','Banner Updated Successfully!');
        
    }

    
    public function destroy($id)
    {
        // Get Category Image
        $bannerImage = Banner::where('id',$id)->first();

        // Get banner Image Path
        $banner_image_path = 'uploads/image/banner/';

        // Delete banner Image From banner_image folder if exists
        if(file_exists($banner_image_path.$bannerImage->photo)){
            unlink($banner_image_path.$bannerImage->photo);
        }

        // Delete banner image from banner folder
        Banner::where('id',$id)->delete();
        return redirect()->back()->with('message','banner deleted successfully!');
    }


    /*------ Update Banner Status ------*/
    public function updateBannerStatus(Request $request)
    {   
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die; 
            if($data['status']=="active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Banner::where('id',$data['banner_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'banner_id'=>$data['banner_id']]);
        }
    }
    
}
