<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Section;
use App\Models\User;
use Auth;

class CouponsController extends Controller
{
    public function coupons()
    {
        $coupons = Coupon::get()->toArray();
        return view('admin.coupon.coupons')->with(compact('coupons'));
    }

    public function addEditCoupon(Request $request,$id=null)
    {
        if($id==""){
            // Add Coupon
            $title = "Add Coupon";
            $coupon = new Coupon;
            $selCats = array();
            $selUsers = array();
            $message = "Coupon added Successfully!";

        }else{
            // Edit Coupon
            $title = "Edit Coupon";
            $coupon = Coupon::find($id);
            $selCats = explode(',',$coupon['categories']);
            $selUsers = explode(',',$coupon['users']);
            $message = "Coupon Updated Successfully!";

        }

        if($request->isMethod('post')){
            $data = $request->all();

            $request->validate(
                [
                    'categories' => 'required',
                    'coupon_option' => 'required',
                    'coupon_type' =>'required',
                    'amount_type' => 'required',
                    'amount' => 'required|numeric',
                    'expiry_date' => 'required',
                ],

                [
                    'categories.required' => 'Select Categories',
                    'coupon_option.required' => 'Select Coupon Option',
                    'coupon_type.required' => 'Select Coupon Type',
                    'amount_type.required' => 'Select Amount Type',
                    'amount.required' => 'Enter Amount',
                    'amount.numeric' => 'Enter Valid Amount',
                    'expiry_date.required' => 'Enter Expiry Date',
                ]
            );

            if(isset($data['categories'])){
                $categories = implode(",",$data['categories']);
            }else{
                $categories = "";
            }
            
            if(isset($data['users'])){
                $users = implode(",",$data['users']);
            }else{
                $users = "";
            }

            if($data['coupon_option']=="Automatic"){
                $coupon_code = str_random(8);
            }else{
                $coupon_code = $data['coupon_code'];
            }

            $coupon->coupon_option = $data['coupon_option'];
            $coupon->coupon_code = $coupon_code;
            $coupon->categories = $categories;
            $coupon->users = $users;
            $coupon->coupon_type = $data['coupon_type'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->amount = $data['amount'];
            $coupon->expiry_date = $data['expiry_date'];
            $coupon->save();

            return redirect()->route('coupons')->with('message',$message);

        }
        
        $categories = Section::with('categories')->get()->toArray();
        $users = User::select('email')->where('status',1)->get();
        return view('admin.coupon.add_edit')->with(compact('title','coupon','message','categories','users','selCats','selUsers'));
    }

    public function destroy($id)
    {
        Coupon::where('id',$id)->delete();
        return redirect()->back()->with('message','Coupon has been deleted Successfully!');

    }

    /*------ Update Coupon Status ------*/
    public function updateCouponStatus(Request $request)
    {   
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die; 
            if($data['status']=="active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Coupon::where('id',$data['coupon_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'coupon_id'=>$data['coupon_id']]);
        }
    }
}
