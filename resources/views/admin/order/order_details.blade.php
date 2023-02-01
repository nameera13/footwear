<?php use App\Models\Product; ?>
@extends('admin.master')
@section('admin')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Order Details</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bi bi-house" style="color:gray;"></i></a></li>
              <li class="breadcrumb-item active"><a href="{{ route('order') }}" style="color:gray;">Back to Orders</a></li>
              <!-- <li class="breadcrumb-item active"></li> -->
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
</section>
    @if(Session::has('message'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong> {{ session::get('message') }} </strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h2 class="card-title">Order Details</h2>
                    </div>              
                    <div class="card-body">
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight:550;">Order ID : </label>
                            <label style="font-weight:470;">#{{ $orderDetails['id'] }}</label>                    
                        </div>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight:550;">Order Date : </label>
                            <label style="font-weight:470;">{{ date('Y-m-d h:i:s', strtotime($orderDetails['created_at'])); }}</label>                    
                        </div>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight:550;">Order Status : </label>
                            <label style="font-weight:470;">{{ $orderDetails['order_status'] }}</label>                    
                        </div>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight:550;">Order Total : </label>
                            <label style="font-weight:470;">{{ $orderDetails['grand_total'] }}</label>                    
                        </div>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight:550;">Shippng Charges : </label>
                            <label style="font-weight:470;">{{ $orderDetails['shipping_charges'] }}</label>                    
                        </div>
                        @if(!empty($orderDetails['coupon_code']))
                            <div class="form-group" style="height: 15px;">
                                <label style="font-weight:550;">Coupon Code : </label>
                                <label style="font-weight:470;">{{ $orderDetails['coupon_code'] }}</label>                    
                            </div>
                            <div class="form-group" style="height: 15px;">
                                <label style="font-weight:550;">Coupon Amount : </label>
                                <label style="font-weight:470;">{{ $orderDetails['coupon_amount'] }}</label>                    
                            </div>
                        @endif
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight:550;">Payment Method : </label>
                            <label style="font-weight:470;">{{ $orderDetails['payment_method'] }}</label>                    
                        </div>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight:550;">Payment Gateway : </label>
                            <label style="font-weight:470;">{{ $orderDetails['payment_gateway'] }}</label>                    
                        </div>

                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                        <h2 class="card-title">Delivery Address</h2>
                        </div>              
                        <div class="card-body">
                            <div class="form-group" style="height: 15px;">
                                <label style="font-weight:550;">Name : </label>
                                <label style="font-weight:470;">{{ ucfirst($orderDetails['firstname']) }}&nbsp;{{ ucfirst($orderDetails['lastname']) }}</label>                    
                            </div>
                            @if(!empty($orderDetails['address']))
                            <div class="form-group" style="height: 15px;">
                                <label style="font-weight:550;">Address : </label>
                                <label style="font-weight:470;">{{ $orderDetails['address'] }}</label>                    
                            </div>
                            @endif
                            @if(!empty($orderDetails['city']))
                            <div class="form-group" style="height: 15px;">
                                <label style="font-weight:550;">City : </label>
                                <label style="font-weight:470;">{{ $orderDetails['city'] }}</label>                    
                            </div>
                            @endif
                            @if(!empty($orderDetails['state']))
                            <div class="form-group" style="height: 15px;">
                                <label style="font-weight:550;">State : </label>
                                <label style="font-weight:470;">{{ $orderDetails['state'] }}</label>                    
                            </div>
                            @endif
                            @if(!empty($orderDetails['country']))
                            <div class="form-group" style="height: 15px;">
                                <label style="font-weight:550;">Country : </label>
                                <label style="font-weight:470;">{{ $orderDetails['country'] }}</label>                    
                            </div>
                            @endif
                            @if(!empty($orderDetails['pincode']))                        
                            <div class="form-group" style="height: 15px;">
                                <label style="font-weight:550;">Pincode : </label>
                                <label style="font-weight:470;">{{ $orderDetails['pincode'] }}</label>                    
                            </div>
                            @endif
                            <div class="form-group" style="height: 15px;">
                                <label style="font-weight:550;">Mobile : </label>
                                <label style="font-weight:470;">{{ $orderDetails['mobile'] }}</label>                    
                            </div>
                            
                        </div>
                    </div>
                </div>   
            </div>
        </div> 
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                    <h2 class="card-title">Customer Details</h2>
                    </div>              
                    <div class="card-body">
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight:550;">Name : </label>
                            <label style="font-weight:470;">{{ ucfirst($userDetails['firstname']) }}&nbsp;{{ ucfirst($userDetails['lastname']) }}</label>                    
                        </div>
                        @if(!empty($userDetails['address']))
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight:550;">Address : </label>
                            <label style="font-weight:470;">{{ $userDetails['address'] }}</label>                    
                        </div>
                        @endif
                        @if(!empty($userDetails['city']))
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight:550;">City : </label>
                            <label style="font-weight:470;">{{ $userDetails['city'] }}</label>                    
                        </div>
                        @endif
                        @if(!empty($userDetails['state']))
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight:550;">State : </label>
                            <label style="font-weight:470;">{{ $userDetails['state'] }}</label>                    
                        </div>
                        @endif
                        @if(!empty($userDetails['country']))
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight:550;">Country : </label>
                            <label style="font-weight:470;">{{ $userDetails['country'] }}</label>                    
                        </div>
                        @endif
                        @if(!empty($userDetails['pincode']))                        
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight:550;">Pincode : </label>
                            <label style="font-weight:470;">{{ $userDetails['pincode'] }}</label>                    
                        </div>
                        @endif
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight:550;">Mobile : </label>
                            <label style="font-weight:470;">{{ $userDetails['mobile'] }}</label>                    
                        </div>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight:550;">Email : </label>
                            <label style="font-weight:470;">{{ $userDetails['email'] }}</label>                    
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                    <h2 class="card-title">Update Order Status</h2>
                    </div>              
                    <div class="card-body">
                        <form action="{{ url('admin/update-order-status') }}" method="post">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $orderDetails['id'] }}">
                            <select name="order_status" required="">
                                <option value="">select</option>
                                @foreach($orderStatuses as $status)
                                    <option value="{{ $status['name'] }}" @if(!empty($orderDetails['order_status']) && $orderDetails['order_status']==$status['name']) selected="" @endif>{{ $status['name'] }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-sm btn-secondary">Update</button>
                        </form>
                    </div>
                </div>   
            </div>
        </div> 
        
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                <h2 class="card-title">Ordered Products</h2>
                </div>              
                <div class="card-body">
                <table class="bg-white table table-bordered table-hover text-center" style="margin-top:10px;">                
                <thead>
                    
                    <tr>
                        <th>Product Image</th>
                        <th>Product Code</th>
                        <th>Product Name</th>
                        <th>Product Size</th>
                        <th>Product Color</th>
                        <th>Product Qty</th>
                        <th>Item Status</th>
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
                        <td>
                            <form action="{{ url('admin/update-order-item-status') }}" method="post">
                                @csrf
                                <input type="hidden" name="order_item_id" value="{{ $product['id'] }}">
                                <select name="item_status" required="">
                                    <option value="">select</option>
                                    @foreach($orderItemStatuses as $status)
                                        <option value="{{ $status['name'] }}" @if(!empty($product['item_status']) && $product['item_status']==$status['name']) selected="" @endif>{{ $status['name'] }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-sm btn-secondary">Update</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>                
            </table>
                </div>
            </div>   
        </div>
    </div>
</section>

@endsection