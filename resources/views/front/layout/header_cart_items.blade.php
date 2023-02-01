<?php 
    use App\Models\Product;
    use App\Models\Cart;
    $getCartItems = Cart::getCartItems();
?>

<div id="header-cart" class="block block-cart">
    <ul class="mini-products-list">
        @php $total_price = 0 @endphp
        @foreach($getCartItems as $item)
            <?php 
                $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'],$item['size']); 
            ?>  
        <li class="item">
            <a class="product-image" href="{{ url('product/'.$item['product_id']) }}">
                <img src="{{ asset('uploads/image/product/small/'.$item['product']['product_image']) }}" alt="Product" title="" />
            </a>
            <div class="product-details">
                <a class="pName" href="#">{{ $item['product']['product_name'] }}({{ $item['product']['product_code'] }})</a>
                <div class="variant-cart">{{ $item['size'] }}</div>
                
                <div class="priceRow">
                    <div class="product-price">
                        <span class="money">Rs.{{$getDiscountAttributePrice['final_price']}} x {{ $item['quantity'] }}</span>
                    </div>
                </div>
            </div>
        </li>
        @php $total_price = $total_price + ($getDiscountAttributePrice['final_price'] * $item['quantity']) @endphp                
        @endforeach
    </ul>
    <div class="total">
        <div class="total-in">
            <span class="label">Total:</span><span class="product-price"><span class="money">Rs.{{ $total_price }}</span></span>
        </div>
        <div class="buttonSet text-center">
            <a href="{{url('cart')}}" class="btn btn-secondary btn--small">View Cart</a>
            <a href="{{url('checkout')}}" class="btn btn-secondary btn--small">Checkout</a>
        </div>
    </div>
</div>