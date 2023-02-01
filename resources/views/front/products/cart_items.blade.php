<?php use app\Models\Product; ?>
<div class="row">
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 main-col">        
        <form action="#" method="post" class="cart style2">
            <table>
                <thead class="cart__row cart__header">
                    <tr>
                        <th colspan="2" class="text-center">Product</th>
                        <th class="text-left">Price</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-right">Total</th>
                        <th class="action">&nbsp;</th> 
                    </tr>
                </thead>
                <tbody>
                    @php $total_price = 0 @endphp
                    @foreach($getCartItems as $item)
                    <?php 
                        $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'],$item['size']); 
                    ?>                            
                    <tr class="cart__row border-bottom line1 cart-flex border-top">
                        <td class="cart__image-wrapper cart-flex-item">
                            <a href="{{ url('product/'.$item['product_id']) }}"><img class="cart__image" src="{{ asset('uploads/image/product/small/'.$item['product']['product_image']) }}" alt=""></a>
                        </td>
                        <td class="cart__meta small--text-left cart-flex-item">
                            <div class="list-view-item__title">
                                <a href="#">{{ $item['product']['product_name'] }}({{ $item['product']['product_code'] }})</a>
                            </div>
                            
                            <div class="cart__meta-text">
                                Color: {{ $item['product']['product_color'] }}<br>Size: {{ $item['size'] }}<br>
                            </div>
                        </td>
                        <td class="cart__price-wrapper cart-flex-item">
                            <span class="money">
                                @if($getDiscountAttributePrice['discount']> 0)
                                <div class="product-price">                                
                                    <span class="price">Rs.{{$getDiscountAttributePrice['final_price']}}</span>
                                    <span class="old-price">Rs.{{$getDiscountAttributePrice['product_price']}}</span>
                                </div>
                                @else
                                <div class="product-price">
                                    <span class="price">Rs.{{$getDiscountAttributePrice['product_price']}}</span>
                                </div>
                                @endif
                            </span>
                        </td>
                        <td class="cart__update-wrapper cart-flex-item text-right">
                            <div class="cart__qty text-center">
                                <div class="qtyField">
                                    <a class="qtyBtn minus UpdateCartItem" data-cartid="{{ $item['id'] }}" data-qty="{{ $item['quantity'] }}" href="javascript:void(0);"><i class="icon icon-minus"></i></a>
                                    <input class="cart__qty-input qty" type="text" name="updates[]" id="qty" value="{{ $item['quantity'] }}" pattern="[0-9]*">
                                    <a class="qtyBtn plus UpdateCartItem" data-cartid="{{ $item['id'] }}" data-qty="{{ $item['quantity'] }}" href="javascript:void(0);"><i class="icon icon-plus"></i></a>
                                </div>
                            </div>
                        </td>
                        <td class="text-right small--hide cart-price">
                            <div><span class="money">Rs.{{$getDiscountAttributePrice['final_price'] * $item['quantity']}}</span></div>
                        </td>
                        <td class="text-center small--hide" >
                            <!-- <a href="#" class="btn btn--secondary cart__remove" title=""><i class="icon icon anm anm-edit-l"></i></a> -->
                            <a href="#" class="btn btn--secondary cart__remove deleteCartItem" data-cartid="{{ $item['id'] }}" title="Remove"><i class="icon icon anm anm-times-l"></i></a>
                        </td>
                    </tr>
                    @php $total_price = $total_price + ($getDiscountAttributePrice['final_price'] * $item['quantity']) @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-left"></td>
                        
                        <td colspan="3" class="text-right">
                            <!-- <button type="submit" name="clear" class="btn btn-secondary btn--small  small--hide">Clear Cart</button> -->
                            <!-- <button type="submit" name="update" class="btn btn-secondary btn--small cart-continue ml-2">Update Cart</button> -->
                            <a href="#" class="btn btn-secondary btn--small cart-continue">Continue shopping</a>
                        </td>
                    </tr>
                </tfoot>
            </table> 
        </form>                                            
    </div>           
</div>

<div class="row">                
    <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4">
        <h5>Discount Codes</h5>
        <form method="post" id="ApplyCoupon" action="javascript:void(0);" @if(Auth::check()) user="1" @endif>@csrf
            <div class="form-group">
                <label for="address_zip">Enter your coupon code if you have one.</label>
                <input type="text" name="code" id="code" placeholder="Enter Coupon Code">
            </div>
            <div class="actionRow">
                <div><input type="submit" class="btn btn-secondary btn--small" value="Apply Coupon"></div>
            </div>
        </form>
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4">

    </div>

    <div class="col-12 col-sm-12 col-md-4 col-lg-4 cart__footer">
        <div class="solid-border">	
            <div class="row border-bottom pb-2">
            <span class="col-12 col-sm-6 cart__subtotal-title">Subtotal</span>
            <span class="col-12 col-sm-6 text-right"><span class="money">Rs.{{ $total_price }}</span></span>
            </div>
            <div class="row border-bottom pb-2 pt-2">
            <span class="col-12 col-sm-6 cart__subtotal-title">Coupon Discount</span>
            <span class="col-12 col-sm-6 text-right couponAmount">
                @if(Session::has('couponAmount'))
                    Rs.{{ Session::get('couponAmount') }}
                @else
                    Rs.0
                @endif 
            </span>
            </div>
            <div class="row border-bottom pb-2 pt-2">
            <span class="col-12 col-sm-6 cart__subtotal-title">Shipping</span>
            <span class="col-12 col-sm-6 text-right">Free shipping</span>
            </div>
            <div class="row border-bottom pb-2 pt-2">
            <span class="col-12 col-sm-6 cart__subtotal-title"><strong>Total</strong></span>
            <span class="col-12 col-sm-6 cart__subtotal-title cart__subtotal text-right"><span class="money grandTotal">Rs.{{ $total_price - Session::get('couponAmount') }}</span></span>
            </div>
            <div class="cart__shipping">Shipping &amp; taxes calculated at checkout</div>
            <p class="cart_tearm">
            <label>
                <input type="checkbox" name="tearm" class="checkbox" value="tearm" required="">
                I agree with the terms and conditions
            </label>
            </p>
            <a href="{{url('checkout')}}"><input type="submit" name="checkout" id="cartCheckout" class="btn btn--small-wide checkout" value="Proceed To Checkout"></a>
            <div class="paymnet-img"><img src="{{asset('user/assets/images/payment-img.jpg')}}" alt="Payment"></div>
            <p><a href="#;">Checkout with Multiple Addresses</a></p>
        </div>   
    </div>
</div>