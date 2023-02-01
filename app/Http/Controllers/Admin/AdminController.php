<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Image;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    /*------ dashboard ------*/

    public function dashboard()
    {
        return view('admin.dashboard');
    }

     /*------ Login ------*/

    public function login(Request $request)
    {
        // dd($request->all());

        $check = $request->all();
        if(Auth::guard('admin')->attempt(['email'=> $check['email'],'password'=>$check['password']]))
        {
            return redirect()->route('admin.dashboard')->with('message','Admin Login Successfully!');
        }
        else
        {
            return back()->with('message','Invalid Email or Password');
        }
    }

     /*------ Logout ------*/

    public function logout()
    {

        Auth::guard('admin')->logout();
        return redirect()->route('login_form')->with('message','Admin Logout Successfully!');
    }

     /*------ Register Form ------*/

     public function registerform()
     {
        return view('admin.register');
     }

     /*------ Register ------*/

     public function register(Request $request)
     {
        // dd($request->all());

        $request->validate(
            [
                'name' => 'required|string|max:20',
                'email' => 'required|email|unique:admins,email',
                'password' => 'required|alpha_num|min:6',
                'confirmPassword' => 'required|same:password',
            ],

            [
                'name.required' => 'Please Enter Your Name',
                'name.max' => 'Name must not be more than 20 chars',
                'email.required' => 'Please Enter Your email',
                'email.email' => 'Email must be a valid email address',
                'password.required' => 'Please Enter the Password',
                'password.alpha_num' => 'Password must be alpha numeric chars',
                'password.min' => 'Password should be minium 6 chars',
                'confirmPassword.required' => 'Please Re-enter the Password',
                'confirmPassword.same' => 'Password must be same',
            ]
        );
        
        Admin::insert([
            'name' => ucfirst($request->name),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => Carbon::now(), 
        ]);

        return redirect()->route('login_form')->with('message','Admin Created Successfully!');

     }

    /*------ Update Admin Password ------*/

    public function updateAdminPassword(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            // check if Current Password entered by admin is correct 
            if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password)){
                // check if New Password is matching with Confirm Password
                if($data['confirm_password']==$data['new_password']){
                    Admin::where('id',Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['new_password'])]);
                    return redirect()->back()->with('message','Password has been updated Successfully!');
                }else{
                    return redirect()->back()->with('error_message','New Password and Confirm Password does not match!');
                }
            }else{
                return redirect()->back()->with('error_message','Your Current Password is Incorrect!');
            }
        }
        $adminDetails = Admin::where('email',Auth::guard('admin')->user()->email)->first()->toArray();
        return view('admin.profile.update_admin_password')->with(compact('adminDetails'));
    }

    /*------ Check Admin Password ------*/
    public function checkAdminPassword(Request $request)
    {
        $data = $request->all();
        // echo"<pre>"; print_r($data); die;
        if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password)){
            return "true";
        }else{
            return "false";
        }

    }

    /*------ Update Admin Details ------*/
    public function updateAdminDetails(Request $request)
    {
        
        if($request->isMethod('post')){
            $data = $request->all();

            $request->validate(
                [
                    'name' => 'required|regex:/^[\pL\s\-]+$/u|max:20',    
                ],
    
                [
                    'name.required' => 'Please Enter Your Name',
                    'name.regex' => 'The Admin Name Format is invalid',
                    'name.max' => 'Name must not be more than 20 chars',
                ]
            );

            if($request->hasFile('image')){
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();

                    // Generate New Image Name
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'uploads/admin_image/'.$imageName;

                    // Upload Image
                    Image::make($image_tmp)->save($imagePath);
                }
            
            }else if(!empty($data['current_admin_image'])){
                $imageName = $data['current_admin_image'];
            }

            Admin::where('id',Auth::guard('admin')->user()->id)->update(['name'=>ucfirst($data['name']),'image'=>$imageName]);
            return redirect()->back()->with('message','Admin Details Updated Successfully!');
        }
        return view('admin.profile.update_admin_details');
    }


    /*------ Delete Admin Image ------*/
    public function deleteAdminImage($id)
    {
        // Get Category Image
        $adminImage = Admin::select('image')->where('id',Auth::guard('admin')->user()->id)->first();

        // Get Category Image Path
        $admin_image_path = 'uploads/admin_image/'; 

        // Delete Category Image From image folder if exists
        if(file_exists($admin_image_path.$adminImage->image)){
            unlink($admin_image_path.$adminImage->image);
        }

        // Delete Category image from category folder
        Admin::where('id',Auth::guard('admin')->user()->id)->update(['image'=>'']);
        return redirect()->back()->with('message','Admin Image has been deleted successfully!');

    }


}
