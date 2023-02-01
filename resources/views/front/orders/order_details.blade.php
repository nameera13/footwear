<?php use App\Models\Product; ?>
@extends('front.layout.layouts')
@section('content')
<div id="page-content">
    <!--Page Title-->
    <div class="page section-header text-center">
        <div class="page-title">
            <div class="wrapper"><h1 class="page-width">Orders #{{ $orderDetails['id'] }} Details</h1></div>            
        </div>
        <div class="wrapper"><h2 class=""><a href="{{ url('orders') }}">Orders</a></h2></div>
    </div>
    <!--End Page Title-->
    
    <div class="container">
        <div class="table-responsive-sm order-table"> 
            <table class="bg-white table table-bordered table-hover text-center">
                <tr>
                    <th colspan="2"><strong style="font-size:20px;">Order Details</strong></th>
                </tr>
                <tr>
                    <th>Order Date</th>
                    <td>{{ date('Y-m-d h:i:s', strtotime($orderDetails['created_at'])); }}</td>
                </tr> 
                <tr>
                    <th>Order Status</th>
                    <td>{{ $orderDetails['order_status'] }}</td>
                </tr>           
                <tr>
                    <th>Order Total</th>
                    <td>{{ $orderDetails['order_status'] }}</td>
                </tr> 
                <tr>
                    <th>Shipping Charges</th>
                    <td>{{ $orderDetails['shipping_charges'] }}</td>
                </tr>
                @if($orderDetails['coupon_code']!="") 
                <tr>
                    <th>Coupon Code</th>
                    <td>{{ $orderDetails['coupon_code'] }}</td>
                </tr> 
                <tr>
                    <th>Coupon Amount</th>
                    <td>{{ $orderDetails['coupon_amount'] }}</td>
                </tr>
                @endif 
                <tr>
                    <th>Payment Method</th>
                    <td>{{ $orderDetails['payment_method'] }}</td>
                </tr> 
               
            </table>

            <table class="bg-white table table-bordered table-hover text-center" style="margin-top:40px;">                
                <thead>
                    <tr>
                        <th colspan="6"><strong style="font-size:20px;">Product Details</strong></th>
                    </tr>
                    <tr>
                        <th>Product Image</th>
                        <th>Product Code</th>
                        <th>Product Name</th>
                        <th>Product Size</th>
                        <th>Product Color</th>
                        <th>Product Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderDetails['orders_products'] as $product)
                    <tr>
                        <td>
                            @php $getProductImage = Product::getProductImage($product['product_id']) @endphp
                            <a href="{{ url('product/'.$product['product_id']) }}">
                                <img style="width:80px;" src="{{ asset('uploads/image/product/small/'.$getProductImage) }}" alt="">
                            </a>
                        </td>
                        <td>{{ $product['product_code'] }}</td>
                        <td>{{ $product['product_name'] }}</td>
                        <td>{{ $product['product_size'] }}</td>
                        <td>{{ $product['product_color'] }}</td>
                        <td>{{ $product['product_qty'] }}</td>
                    </tr>
                    @endforeach
                </tbody>                
            </table>

            <table class="bg-white table table-bordered table-hover text-center" style="margin-top:40px;">
                <tr>
                    <th colspan="2"><strong style="font-size:20px;">Delivery Address</strong></th>
                </tr>                 
                <tr>
                    <th>FirstName</th>
                    <td>{{ $orderDetails['firstname'] }}</td>
                </tr>
                <tr>
                    <th>LastName</th>
                    <td>{{ $orderDetails['lastname'] }}</td>
                </tr>           
                <tr>
                    <th>Address</th>
                    <td>{{ $orderDetails['address'] }}</td>
                </tr> 
                <tr>
                    <th>City</th>
                    <td>{{ $orderDetails['city'] }}</td>
                </tr>                 
                <tr>
                    <th>state</th>
                    <td>{{ $orderDetails['state'] }}</td>
                </tr> 
                <tr>
                    <th>Country</th>
                    <td>{{ $orderDetails['country'] }}</td>
                </tr> 
                <tr>
                    <th>Pincode</th>
                    <td>{{ $orderDetails['pincode'] }}</td>
                </tr> 
                <tr>
                    <th>Mobile</th>
                    <td>{{ $orderDetails['mobile'] }}</td>
                </tr>                
            </table>
        </div>
    </div>
    
</div>
@endsection