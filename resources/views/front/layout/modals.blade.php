<?php use App\Models\Product; ?>
<div class="tab-slider-product section">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div class="section-header text-center">
                    <h2 class="h2">Top Collection</h2>
                    <p></p>
                </div>
                <div class="tabs-listing">
                    <ul class="tabs clearfix">
                        <li class="active" rel="tab1">New Arrivals</li>
                        <li rel="tab2">Best Sellers</li>
                        <li rel="tab3">Discount Products</li>
                        <li rel="tab4">Featured Products</li>
                    </ul>
                    <div class="tab_container">
                    <div id="tab1" class="tab_content grid-products">
                        <div class="productSlider grid-products grid-products-hover-gry">
                            @foreach($newProducts as $product)
                            <?php $product_image_path = 'uploads/image/product/small/'.$product['product_image']; ?>
                            <div class="col-12 item">
                                <!-- start product image -->
                                <div class="product-image">
                                    <!-- start product image -->
                                    <a href="{{url('product/'.$product['id'])}}" class="grid-view-item__link">
                                        <!-- image -->
                                        @if(!empty($product['product_image']) && file_exists($product_image_path))
                                        <img class="primary blur-up lazyload" data-src="{{asset($product_image_path)}}" src="{{asset($product_image_path)}}" alt="image" title="product">
                                        <!-- End image -->
                                        <!-- Hover image -->
                                        <img class="hover blur-up lazyload" data-src="{{asset($product_image_path)}}" src="{{asset($product_image_path)}}" alt="image" title="product">
                                        <!-- End hover image -->
                                        @else
                                        <img class="primary blur-up lazyload" data-src="{{asset('uploads/image/product/small/no-image.png')}}" alt="image" title="product">
                                        <!-- End image -->
                                        <!-- Hover image -->
                                        <img class="hover blur-up lazyload" data-src="{{asset('uploads/image/product/small/no-image.png')}}" src="{{asset('uploads/image/product/small/no-image.png')}}" alt="image" title="product">
                                        <!-- End hover image -->
                                        @endif

                                    </a>
                                    <!-- end product image -->
                                    <!-- Start product button -->
                                    
                                    <div class="button-set">
                                        
                                        <div class="wishlist-btn">
                                            <a class="wishlist add-to-wishlist" href="wishlist.html">
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
                                        <a href="{{url('product/'.$product['id'])}}">{{ $product['product_name'] }}</a>
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
                                </div>
                                <!-- End product details -->
                            </div>
                            @endforeach
                            
                        </div>
                    </div>
                    </div>
                    <div class="tab_container">
                    <div id="tab2" class="tab_content grid-products">
                        <div class="productSlider grid-products grid-products-hover-gry">   
                        @foreach($bestSeller as $product)
                            <?php $product_image_path = 'uploads/image/product/small/'.$product['product_image']; ?>
                            <div class="col-12 item">
                                <!-- start product image -->
                                <div class="product-image">
                                    <!-- start product image -->
                                    <a href="{{url('product/'.$product['id'])}}" class="grid-view-item__link">
                                        <!-- image -->
                                        @if(!empty($product['product_image']) && file_exists($product_image_path))
                                        <img class="primary blur-up lazyload" data-src="{{asset($product_image_path)}}" src="{{asset($product_image_path)}}" alt="image" title="product">
                                        <!-- End image -->
                                        <!-- Hover image -->
                                        <img class="hover blur-up lazyload" data-src="{{asset($product_image_path)}}" src="{{asset($product_image_path)}}" alt="image" title="product">
                                        <!-- End hover image -->
                                        @else
                                        <img class="primary blur-up lazyload" data-src="{{asset('uploads/image/product/small/no-image.png')}}" alt="image" title="product">
                                        <!-- End image -->
                                        <!-- Hover image -->
                                        <img class="hover blur-up lazyload" data-src="{{asset('uploads/image/product/small/no-image.png')}}" src="{{asset('uploads/image/product/small/no-image.png')}}" alt="image" title="product">
                                        <!-- End hover image -->
                                        @endif

                                    </a>
                                    <!-- end product image -->
                                    <!-- Start product button -->
                                    
                                    <div class="button-set">
                                        
                                        <div class="wishlist-btn">
                                            <a class="wishlist add-to-wishlist" href="wishlist.html">
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
                                        <a href="{{url('product/'.$product['id'])}}">{{ $product['product_name'] }}</a>
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
                                </div>
                                <!-- End product details -->
                            </div>
                            @endforeach
                        </div>
                                   
                    </div>
                    </div>
                    <div class="tab_container">
                    <div id="tab3" class="tab_content grid-products">
                        <div class="productSlider grid-products grid-products-hover-gry">  
                        @foreach($discountedProducts as $product)
                            <?php $product_image_path = 'uploads/image/product/small/'.$product['product_image']; ?>
                            <div class="col-12 item">
                                <!-- start product image -->
                                <div class="product-image">
                                    <!-- start product image -->
                                    <a href="{{url('product/'.$product['id'])}}" class="grid-view-item__link">
                                        <!-- image -->
                                        @if(!empty($product['product_image']) && file_exists($product_image_path))
                                        <img class="primary blur-up lazyload" data-src="{{asset($product_image_path)}}" src="{{asset($product_image_path)}}" alt="image" title="product">
                                        <!-- End image -->
                                        <!-- Hover image -->
                                        <img class="hover blur-up lazyload" data-src="{{asset($product_image_path)}}" src="{{asset($product_image_path)}}" alt="image" title="product">
                                        <!-- End hover image -->
                                        @else
                                        <img class="primary blur-up lazyload" data-src="{{asset('uploads/image/product/small/no-image.png')}}" alt="image" title="product">
                                        <!-- End image -->
                                        <!-- Hover image -->
                                        <img class="hover blur-up lazyload" data-src="{{asset('uploads/image/product/small/no-image.png')}}" src="{{asset('uploads/image/product/small/no-image.png')}}" alt="image" title="product">
                                        <!-- End hover image -->
                                        @endif

                                    </a>
                                    <!-- end product image -->
                                    <!-- Start product button -->
                                    
                                    <div class="button-set">
                                        
                                        <div class="wishlist-btn">
                                            <a class="wishlist add-to-wishlist" href="wishlist.html">
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
                                        <a href="{{url('product/'.$product['id'])}}">{{ $product['product_name'] }}</a>
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
                                </div>
                                <!-- End product details -->
                            </div>
                            @endforeach
                        </div>            
                    </div>
                    </div>
                    <div class="tab_container">
                    <div id="tab4" class="tab_content grid-products">
                        <div class="productSlider grid-products grid-products-hover-gry">  
                        @foreach($featuredProducts as $product)
                            <?php $product_image_path = 'uploads/image/product/small/'.$product['product_image']; ?>
                            <div class="col-12 item">
                                <!-- start product image -->
                                <div class="product-image">
                                    <!-- start product image -->
                                    <a href="{{url('product/'.$product['id'])}}" class="grid-view-item__link">
                                        <!-- image -->
                                        @if(!empty($product['product_image']) && file_exists($product_image_path))
                                        <img class="primary blur-up lazyload" data-src="{{asset($product_image_path)}}" src="{{asset($product_image_path)}}" alt="image" title="product">
                                        <!-- End image -->
                                        <!-- Hover image -->
                                        <img class="hover blur-up lazyload" data-src="{{asset($product_image_path)}}" src="{{asset($product_image_path)}}" alt="image" title="product">
                                        <!-- End hover image -->
                                        @else
                                        <img class="primary blur-up lazyload" data-src="{{asset('uploads/image/product/small/no-image.png')}}" alt="image" title="product">
                                        <!-- End image -->
                                        <!-- Hover image -->
                                        <img class="hover blur-up lazyload" data-src="{{asset('uploads/image/product/small/no-image.png')}}" src="{{asset('uploads/image/product/small/no-image.png')}}" alt="image" title="product">
                                        <!-- End hover image -->
                                        @endif

                                    </a>
                                    <!-- end product image -->
                                    <!-- Start product button -->
                                    
                                    <div class="button-set">
                                        
                                        <div class="wishlist-btn">
                                            <a class="wishlist add-to-wishlist" href="wishlist.html">
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
                                        <a href="{{url('product/'.$product['id'])}}">{{ $product['product_name'] }}</a>
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
                                </div>
                                <!-- End product details -->
                            </div>
                            @endforeach
                        </div>            
                    </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>