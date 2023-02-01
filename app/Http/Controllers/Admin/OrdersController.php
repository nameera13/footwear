<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrdersProduct;
use App\Models\OrderStatus;
use App\Models\OrderItemStatus;
use App\Models\User;

class OrdersController extends Controller
{
    public function orders()
    {
        $orders = Order::with('orders_products')->orderBy('id','Desc')->get()->toArray();
        return view('admin.order.orders')->with(compact('orders'));
    }

    public function orderDetails($id)
    {
        $orderDetails = Order::with('orders_products')->where('id',$id)->first()->toArray();
        $userDetails = User::where('id',$orderDetails['user_id'])->first()->toArray();
        $orderStatuses = OrderStatus::where('status',1)->get()->toArray();
        $orderItemStatuses = OrderItemStatus::where('status',1)->get()->toArray();
        return view('admin.order.order_details')->with(compact('orderDetails','userDetails','orderStatuses','orderItemStatuses'));
    }

    public function updateOrderStatus(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();            
            /* Update Order Status */
            Order::where('id',$data['order_id'])->update(['order_status'=>$data['order_status']]);
            $message = "Order Status has been updated successfully!";
            return redirect()->back()->with('message',$message);
        }
    }

    public function updateOrderItemStatus(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();            
            /* Update Order Item Status */
            OrdersProduct::where('id',$data['order_item_id'])->update(['item_status'=>$data['item_status']]);
            $message = "Order Item Status has been updated successfully!";
            return redirect()->back()->with('message',$message);
        }
    }
}
