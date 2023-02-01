<?php use App\Models\Product; ?>
<div class="grid-products grid--view-items">
    <div class="row">
        @foreach($categoryProducts as $product)
        <div class="col-6 col-sm-6 col-md-4 col-lg-4 item">
            <!-- start product image -->
            <div class="product-image">
                <!-- start product image -->
                <a href="{{ url ('product/'.$product['id']) }}">
                    <?php $product_image_path = 'uploads/image/product/small/'.$product['product_image']; ?>
                    <!-- image -->
                    @if(!empty($product['product_image'])&&file_exists($product_image_path))
                    <img class="primary blur-up lazyload" data-src="{{asset($product_image_path)}}" src="{{asset($product_image_path)}}" alt="image" title="product">
                    <!-- End image -->
                    <!-- Hover image -->
                    <img class="hover blur-up lazyload" data-src="{{asset($product_image_path)}}" src="{{asset($product_image_path)}}" alt="image" title="product">
                    <!-- End hover image -->
                    
                    @else
                    <img class="primary blur-up lazyload" data-src="{{asset('uploads/image/product/small/no-image.png')}}" src="{{asset('uploads/image/product/small/no-image.png')}}" alt="image" title="product">
                    <!-- End image -->
                    <!-- Hover image -->
                    <img class="hover blur-up lazyload" data-src="{{asset('uploads/image/product/small/no-image.png')}}" src="{{asset('uploads/image/product/small/no-image.png')}}" alt="image" title="product">
                    <!-- End hover image -->
                    @endif
                        <!-- product label -->
                    <div class="product-labels rectangular"><span class="lbl on-sale">{{$product['product_discount']}}%</span>
                    <?php $isProductNew = Product::isProductNew($product['id']); ?>
                    @if($isProductNew=="Yes")
                        <span class="lbl pr-label1">new</span>
                    @endif</div>
                    <!-- End product label -->
                </a>
                <!-- end product image -->

                <!-- Start product button -->
                
                <div class="button-set">
                    
                    <div class="wishlist-btn">
                        <a class="wishlist add-to-wishlist" href="#" title="Add to Wishlist">
                            <i class="icon anm anm-heart-l"></i>
                        </a>
                    </div>
                    
                </div>
                <!-- end product button -->
            </div>
            <!-- end product image -->

            <!--start product details -->
            <div class="product-details text-center">
                <!-- product name -->
                <div class="product-name">
                    <a href="{{ url ('product/'.$product['id']) }}">{{ $product['product_name'] }}</a>
                </div>
                <!-- End product name -->
                <!-- product price -->
                <?php $getDiscountPrice = Product::getDiscountPrice($product['id']); ?>
                @if($getDiscountPrice > 0)
                <div class="product-price">                                
                    <span class="price">Rs.{{$getDiscountPrice}}</span>
                    <span class="old-price">Rs.{{$product['product_price']}}</span>
                </div>
                @else
                <div class="product-price">
                    <span class="price">Rs.{{$product['product_price']}}</span>
                </div>
                @endif
                <!-- End product price -->
                
                <!-- <div class="product-review">
                    <i class="font-13 fa fa-star"></i>
                    <i class="font-13 fa fa-star"></i>
                    <i class="font-13 fa fa-star"></i>
                    <i class="font-13 fa fa-star-o"></i>
                    <i class="font-13 fa fa-star-o"></i>
                </div> -->
                <!-- Variant -->
                
                <!-- End Variant -->
            </div>
            <!-- End product details -->
        </div>
        @endforeach
    </div>
    
</div>