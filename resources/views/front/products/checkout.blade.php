<?php use App\Models\Product; ?>
@extends('front.layout.layouts')
@section('content')
<div id="page-content">
    <!--Page Title-->
    <div class="page section-header text-center">
        <div class="page-title">
            <div class="wrapper"><h1 class="page-width">Checkout</h1></div>
        </div>
    </div>
    <!--End Page Title-->
    
    <div class="container">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 mb-3">
                <div class="customer-box returning-customer">
                    <h3><i class="icon anm anm-user-al"></i> Returning customer? <a href="#customer-login" id="customer" class="text-white text-decoration-underline" data-toggle="collapse">Click here to login</a></h3>
                    <div id="customer-login" class="collapse customer-content">
                        <div class="customer-info">
                            <p class="coupon-text">If you have shopped with us before, please enter your details in the boxes below. If you are a new customer, please proceed to the Billing &amp; Shipping section.</p>
                            <form>
                                <div class="row">
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                        <label for="exampleInputEmail1">Email address <span class="required-f">*</span></label>
                                        <input type="email" class="no-margin" id="exampleInputEmail1">
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                        <label for="exampleInputPassword1">Password <span class="required-f">*</span></label>
                                        <input type="password" id="exampleInputPassword1">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-check width-100 margin-20px-bottom">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" value=""> Remember me!
                                            </label>
                                            <a href="#" class="float-right">Forgot your password?</a>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 mb-3">
                <div class="customer-box customer-coupon">
                    <h3 class="font-15 xs-font-13"><i class="icon anm anm-gift-l"></i> Have a coupon? <a href="#have-coupon" class="text-white text-decoration-underline" data-toggle="collapse">Click here to enter your code</a></h3>
                    <div id="have-coupon" class="collapse coupon-checkout-content">
                        <div class="discount-coupon">
                            <div id="coupon" class="coupon-dec tab-pane active">
                                <p class="margin-10px-bottom">Enter your coupon code if you have one.</p>
                                <label class="required get" for="coupon-code"><span class="required-f">*</span> Coupon</label>
                                <input id="coupon-code" required="" type="text" class="mb-3">
                                <button class="coupon-btn btn" type="submit">Apply Coupon</button>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 mb-3">
                @if(Session::has('message'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong> <?php echo session::get('message');?> </strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(Session::has('error_message'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong> <?php echo session::get('error_message'); ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        <form name="checkoutForm" id="checkoutForm" action="{{ url('/checkout') }}" method="post">@csrf   
            <div class="row billing-fields">                            
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 sm-margin-30px-bottom" id="deliveryAddresses">
                    @include('front.products.delivery_addresses')               
                </div>                
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                    <div class="your-order-payment">
                        <div class="your-order">
                            <h2 class="order-title mb-4">Your Order</h2>

                            <div class="table-responsive-sm order-table"> 
                                <table class="bg-white table table-bordered table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th class="text-left">Product Image</th>
                                            <th>Product Name</th>                                           
                                            <th>Size</th>
                                            <th>Price</th>                                            
                                            <th>Qty</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $total_price = 0 @endphp
                                        @foreach($getCartItems as $item)
                                        <?php 
                                            $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'],$item['size']); 
                                        ?>
                                        @php $total_price = $total_price + ($getDiscountAttributePrice['final_price'] * $item['quantity']) @endphp
                                        
                                        <tr>
                                            <td class="cart__image-wrapper cart-flex-item">
                                                <a href="{{ url('product/'.$item['product_id']) }}"><img class="cart__image" src="{{ asset('uploads/image/product/small/'.$item['product']['product_image']) }}" alt=""></a>
                                            </td>
                                            <td class="text-left">{{ $item['product']['product_name'] }}</td>                                            
                                            <td>{{ $item['size'] }}</td> 
                                            <td>
                                                @if($getDiscountAttributePrice['discount']> 0)
                                                <div class="product-price">                                
                                                    <span class="price">Rs.{{$getDiscountAttributePrice['final_price']}}</span>
                                                </div>
                                                @else
                                                <div class="product-price">
                                                    <span class="price">Rs.{{$getDiscountAttributePrice['product_price']}}</span>
                                                </div>
                                                @endif
                                            </td>                                       
                                            <td>{{ $item['quantity'] }}</td>
                                            <td>
                                                Rs.{{$getDiscountAttributePrice['final_price'] * $item['quantity'] }}
                                            </td>
                                        </tr>                                        
                                        @endforeach
                                    </tbody>
                                    <tfoot class="font-weight-600">
                                        <tr>
                                            <td colspan="5" class="text-right">Sub Total </td>
                                            <td>{{ $total_price }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right">Shipping Charges</td>
                                            <td>Rs.0</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right">Coupon Discount </td>
                                            <td>
                                            @if(Session::has('couponAmount'))
                                                Rs.{{ Session::get('couponAmount') }}
                                            @else
                                                Rs.0
                                            @endif 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right">Grand Total</td>
                                            <td>Rs.{{ $total_price - Session::get('couponAmount') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>                        
                        <hr />
                        <div class="your-payment">
                            <h2 class="payment-title mb-3">payment method</h2>
                            <div class="payment-method">
                                <div class="payment-accordion">
                                    <div id="accordion" class="payment-section">
                                        <div class="card mb-2">
                                            <div class="card-body">
                                                <input type="radio" name="payment_gateway" id="cash-on-delivery" value="COD">
                                                <label for="cash-on-delivery">Case On Delivery</label>
                                            </div>
                                        </div>                                        
                                        <div class="card margin-15px-bottom border-radius-none">
                                            <div class="card-body">
                                                <input type="radio" name="payment_gateway" id="paypal" value="Paypal">
                                                <label for="paypal">Paypal</label>
                                            </div>
                                        </div>
                                        <p class="cart_tearm">                                            
                                            <input type="checkbox" class="checkbox" id="accept" name="accept" value="Yes" title="Please agree to T&C">
                                            <label for="accept">I agree with the&nbsp;<a href="#"><b>terms and conditions</b></a></label>                                                                                   
                                        </p>
                                    </div>
                                </div>
                                <div class="order-button-payment">
                                    <button class="btn" value="Place order" type="submit">Place order</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>    
</div>
@endsection