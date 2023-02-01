<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seller;
use Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SellerController extends Controller
{

    public function index()
    {
        return view('seller.login');
    }

    /*------ dashboard ------*/

    public function dashboard()
    {
        return view('seller.dashboard');
    }

    /*------ Login ------*/

    public function login(Request $request)
    {
        // dd($request->all());

        $check = $request->all();
        if(Auth::guard('seller')->attempt(['email'=> $check['email'],'password'=>$check['password']]))
        {
            return redirect()->route('seller.dashboard')->with('message','Seller Login Successfully!');
        }
        else
        {
            return back()->with('message','Invalid Email or Password');
        }
    }

    /*------ Logout ------*/

    public function logout()
    {
        Auth::guard('seller')->logout();
        return redirect()->route('seller_login_form')->with('message','Seller Logout Successfully!');
    }

    /*------ Register Form ------*/

    public function registerform()
    {
       return view('seller.register');
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
        
        Seller::insert([
            'name' => ucfirst($request->name),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => Carbon::now(), 
        ]);

        return redirect()->route('seller_login_form')->with('message','Seller Created Successfully!');

     }

}
