<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryAddress;
use Auth;
use Validator;

class AddressController extends Controller
{
    /* -------------- Get Delivery Address -------------- */
    public function getDeliveryAddress(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            $deliveryAddress = DeliveryAddress::where('id',$data['addressid'])->first()->toArray();
            return response()->json(['address'=>$deliveryAddress]);
        }
    }

    /* -------------- Save Delivery Address -------------- */
    public function saveDeliveryAddress(Request $request)
    {
        if($request->ajax()){
            $validator = Validator::make($request->all(),[
                'delivery_firstname'=>'required|max:30',
                'delivery_lastname'=>'required|max:30',
                'delivery_address'=>'required|string|max:150',
                'delivery_city'=>'required',
                'delivery_state'=>'required',
                'delivery_country'=>'required',
                'delivery_pincode'=>'required|numeric|digits:6',
                'delivery_mobile'=>'required|numeric|digits:10',
            ],
            [
                'delivery_firstname.required'=>'The firstname field is required',
                'delivery_firstname.max'=>'The firstname must not be greater than 30 characters.',
                'delivery_lastname.required'=>'The lastname field is required',
                'delivery_lastname.max'=>'The lastname must not be greater than 30 characters.',
                'delivery_address.required'=>'The address field is required',
                'delivery_address.max'=>'The address must not be greater than 150 characters.',
                'delivery_city.required'=>'The city field is required',
                'delivery_state.required'=>'The state field is required',
                'delivery_country.required'=>'The country field is required',
                'delivery_pincode.required'=>'The pincode field is required',
                'delivery_pincode.numeric.digits'=>'The pincode must be a number.The pincode must be 6 digits.',
                'delivery_pincode.digits'=>'The pincode must be 6 digits.',
                'delivery_mobile.required'=>'The mobile field is required',
                'delivery_mobile.numeric.digits'=>'The mobile must be a number.The mobile must be 10 digits.',
                'delivery_mobile.digits'=>'The mobile must be 10 digits.'

            ]);
            if($validator->passes()){
                $data = $request->all();
                $address = array();
                $address['user_id'] = Auth::user()->id;
                $address['firstname'] = $data['delivery_firstname'];
                $address['lastname'] = $data['delivery_lastname'];
                $address['address'] = $data['delivery_address'];
                $address['city'] = $data['delivery_city'];
                $address['state'] = $data['delivery_state'];
                $address['country'] = $data['delivery_country'];
                $address['pincode'] = $data['delivery_pincode'];
                $address['mobile'] = $data['delivery_mobile'];

                if(!empty($data['delivery_id'])){
                    
                    /* Edit Delivery Address */
                    DeliveryAddress::where('id',$data['delivery_id'])->update($address);
                }else{
                    /* Add Delivery Address */
                    DeliveryAddress::create($address);
                }
                $deliveryAddresses = DeliveryAddress::deliveryAddresses();
                return response()->json([
                    'view'=>(String)View::make('front.products.delivery_addresses')->with(compact('deliveryAddresses'))
                ]);
            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }
            
        }
    }

    /* -------------- Remove Delivery Address -------------- */
    public function removeDeliveryAddress(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            DeliveryAddress::where('id',$data['addressid'])->delete();
            $deliveryAddresses = DeliveryAddress::deliveryAddresses();
            return response()->json([
                'view'=>(String)View::make('front.products.delivery_addresses')->with(compact('deliveryAddresses'))
            ]);
        }
    }

}
