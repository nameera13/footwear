<?php
    use App\Models\Product; 
    use App\Models\ProductsFilter;
    $productFilters = ProductsFilter::productFilters();
?>
@extends('front.layout.layouts')
@section('content')

<div id="page-content">
    <!--MainContent-->
    <div id="MainContent" class="main-content" role="main">
        <!--Breadcrumb-->
        <div class="bredcrumbWrap">
            <div class="container breadcrumbs">
                <a href="/" title="Back to the home page">Home</a><span aria-hidden="true">›</span><a href="javascript:;">{{$productDetails['section']['section_name']}}</a><span aria-hidden="true">›</span><span><?php echo $categoryDetails['breadcrumbs']; ?></span>
            </div>
        </div>
        <!--End Breadcrumb-->
        
        <div id="ProductSection-product-template" class="product-template__container prstyle1 container">
            <!--product-single-->
            <div class="product-single">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="product-details-img">
                            <div class="product-thumb">
                                <div id="gallery" class="product-dec-slider-2 product-tab-left">  
                                    @foreach($productDetails['images'] as $image)                              
                                        <a data-image="{{asset('uploads/image/product/large/'.$image['image'])}}" data-zoom-image="{{asset('uploads/image/product/large/'.$image['image'])}}" class="slick-slide slick-cloned" data-slick-index="-4" aria-hidden="true" tabindex="-1">
                                            <img class="blur-up lazyload" src="{{asset('uploads/image/product/large/'.$image['image'])}}" alt="" />
                                        </a>  
                                    @endforeach                               
                                </div>
                                
                            </div>
                            <div class="zoompro-wrap product-zoom-right pl-20">
                                <div class="zoompro-span">
                                    <img class="blur-up lazyload zoompro" data-zoom-image="{{asset('uploads/image/product/large/'.$productDetails['product_image'])}}" alt="" src="{{asset('uploads/image/product/large/'.$productDetails['product_image'])}}" />
                                </div>
                                <!-- <div class="product-labels">
                                    <div class="display-table-cell medium-up--one-third">
                                        <div class="wishlist-btn">
                                            <a class="wishlist add-to-wishlist" style="margin-left:410px;" href="#" title="Add to Wishlist"><i class="icon anm anm-heart-l" aria-hidden="true" ></i> <span></span></a>
                                        </div>
                                    </div>
                                </div> -->
                                    <div class="product-labels"><span class="lbl on-sale">Sale</span><span class="lbl pr-label1">new</span></div>
                                <div class="product-buttons">
                                    @if($productDetails['product_video'])
                                        <a href="{{ url('uploads/video/product/'.$productDetails['product_video']) }}" class="btn popup-video" title="View Video" type="video/MP4"><i class="icon anm anm-play-r" aria-hidden="true"></i></a>                                        
                                    @endif
                                </div>
                            </div>
                            <div class="lightboximages">
                                @foreach($productDetails['images'] as $image)
                                    <a href="{{asset('uploads/image/product/large/'.$image['image'])}}" data-size="1462x2048"></a>
                                @endforeach
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
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
                        <div class="product-single__meta">
                                <h1 class="product-single__title">
                                    <a href="javascript:;">{{$productDetails['product_name']}}</a>
                                </h1>
                                <div class="product-nav clearfix">					
                                    <!-- <a href="#" class="next" title="Next"><i class="fa fa-angle-right" aria-hidden="true"></i></a> -->
                                </div>
                                <div class="prInfoRow">
                                    <div class="product-stock">
                                        @if($totalStock>0)
                                            <span class="instock ">In Stock</span>                                        
                                            <span class="" style="margin-left:30px;"> Only : {{$totalStock }} Left</span>                                                                                    
                                        @else 
                                            <span class="outstock "style="color:red;">Out Of Stock</span> 
                                        @endif
                                    </div>
                                    
                                    <div class="product-sku">SKU: <span class="variant-sku">{{ $productDetails['product_code'] }}</span></div>
                                    <div class="product-review"><a class="reviewLink" href="#tab2"><i class="font-13 fa fa-star"></i><i class="font-13 fa fa-star"></i><i class="font-13 fa fa-star"></i><i class="font-13 fa fa-star-o"></i><i class="font-13 fa fa-star-o"></i><span class="spr-badge-caption">6 reviews</span></a></div>
                                </div>
                                <p class="product-single__price product-single__price-product-template">
                                    <span class="visually-hidden">Regular price</span>
                                    <?php $getDiscountPrice = Product::getDiscountPrice($productDetails['id']); ?>
                                    <span class="getAttributePrice">
                                        @if($getDiscountPrice > 0)
                                        <s id="ComparePrice-product-template"><span class="money">Rs.{{ $productDetails['product_price'] }}</span></s>
                                        <span class="product-price__price product-price__price-product-template product-price__sale product-price__sale--single">
                                            <span id="ProductPrice-product-template"><span class="money">Rs.{{ $getDiscountPrice }}</span></span>
                                        </span>
                                        @else
                                        <span class="product-price__price product-price__price-product-template product-price__sale product-price__sale--single">
                                            <span id="ProductPrice-product-template"><span class="money">Rs.{{ $productDetails['product_price'] }}</span></span>
                                        </span>
                                        @endif
                                    </span>
                                    <span class="discount-badge"> <span class="devider">|</span>&nbsp;
                                        <span>Your Discount</span>
                                        <span id="SaveAmount-product-template" class="product-single__save-amount">
                                        <!-- <span class="money">$100.00</span>
                                        </span> -->
                                        <span class="off">(<span>{{$productDetails['product_discount']}}</span>%)</span>
                                    </span>  
                                </p>
                                <!-- <div class="orderMsg" data-user="23" data-time="24">
                                    <img src="{{asset('user/assets/images/order-icon.jpg')}}" alt="" /> <strong class="items">5</strong> sold in last <strong class="time">26</strong> hours</div>
                                </div> -->
                                @if(!empty($productDetails['description']))
                                <div class="product-single__description rte">                                    
                                <label class="header"><h4><span class="slVariant">Description:</span></h4></label>
                                    <ul>                                                                          
                                        <li>
                                            <span class="slVariant"> {{ $productDetails['description'] }} </span>
                                        </li>
                                    </ul>
                                </div>
                                @endif
                                <form action="{{ url('cart/add') }}" class="post-form" method="post">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $productDetails['id']}}">
                                    <div class="swatch clearfix swatch-0 option1" data-option-index="0">
                                        <div class="product-form__item">
                                        <label class="header">Color: <span class="slVariant">{{ $productDetails['product_color'] }}</span></label>
                                        
                                            @if(count($groupProducts) > 0)
                                            <div style="margin-top:10px;">
                                                <div><label class="header" ><span class="slVariant">Product Color</span></label></div>
                                                <div>
                                                    @foreach($groupProducts as $product)
                                                        <a href="{{ url('product/'.$product['id']) }}">
                                                            <img style="width:50px;" src="{{ asset('uploads/image/product/small/'.$product['product_image']) }}" alt="">
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif                                    

                                        </div>                                    
                                    </div>                                
                                    
                                    <div class="swatch clearfix swatch-1 option2" data-option-index="1">
                                        
                                        <div class="product-form__item"> 
                                            <div class="row">
                                                <div class="col-md-5">
                                                <label class="header"><span class="slVariant">Size:</span></label>
                                                <select name="size" id="getPrice" product_id="{{ $productDetails['id'] }}" required="">
                                                    <!-- <option value="">Select Size</option> -->
                                                    @foreach($productDetails['attributes'] as $attribute)
                                                    <div data-value="XS" class="swatch-element xs available">
                                                        <option value="{{ $attribute['size'] }}">{{$attribute['size']}}</option>                                                    
                                                    </div> 
                                                    @endforeach                                   
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- <p class="infolinks"><a href="#sizechart" class="sizelink btn"> Size Guide</a> <a href="#productInquiry" class="emaillink btn"> Ask About this Product</a></p> -->
                                    <!-- Quantity Action -->
                                    <div class="product-action clearfix">
                                        <div class="product-form__item--quantity">
                                            <div class="wrapQtyBtn">
                                                <div class="qtyField">
                                                    <a class="qtyBtn minus" href="javascript:void(0);"><i class="fa anm anm-minus-r" aria-hidden="true"></i></a>
                                                    <input type="text" id="Quantity" name="quantity" value="1" class="product-form__input qty">
                                                    <a class="qtyBtn plus" href="javascript:void(0);"><i class="fa anm anm-plus-r" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                

                                    <div class="product-action clearfix">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="product-form__item--submit">
                                                    <button type="submit" name="add" class="btn product-form__cart-submit">
                                                        <span>Add to cart</span>
                                                    </button>
                                                </div>
                                            </div>
                                            
                                            <!-- <div class="col-md-6">
                                                <div class="shopify-payment-button" data-shopify="payment-button">
                                                    <button type="button" class="shopify-payment-button__button shopify-payment-button__button--unbranded">Buy now</button>
                                                </div>
                                            </div> -->
                                            
                                        </div>                              
                                        
                                        
                                    </div>
                                </form>
                                <!-- End Product Action -->
                            
                            
                                <div class="display-table shareRow">
                                    <div class="display-table-cell medium-up--one-third">
                                        <div class="wishlist-btn">
                                            <a class="wishlist add-to-wishlist" href="#" title="Add to Wishlist"><i class="icon anm anm-heart-l" aria-hidden="true"></i> Add to Wishlist <span></span></a>
                                        </div>
                                    </div>
                                    <div class="display-table-cell text-right">
                                        <div class="social-sharing">
                                            <a target="_blank" href="#" class="btn btn--small btn--secondary btn--share share-facebook" title="Share on Facebook">
                                                <i class="fa fa-facebook-square" aria-hidden="true"></i> <span class="share-title" aria-hidden="true">Share</span>
                                            </a>
                                            <a target="_blank" href="#" class="btn btn--small btn--secondary btn--share share-twitter" title="Tweet on Twitter">
                                                <i class="fa fa-twitter" aria-hidden="true"></i> <span class="share-title" aria-hidden="true">Tweet</span>
                                            </a>
                                            <a href="#" title="Share on google+" class="btn btn--small btn--secondary btn--share" >
                                                <i class="fa fa-google-plus" aria-hidden="true"></i> <span class="share-title" aria-hidden="true">Google+</span>
                                            </a>
                                            <a target="_blank" href="#" class="btn btn--small btn--secondary btn--share share-pinterest" title="Pin on Pinterest">
                                                <i class="fa fa-pinterest" aria-hidden="true"></i> <span class="share-title" aria-hidden="true">Pin it</span>
                                            </a>
                                            <a href="#" class="btn btn--small btn--secondary btn--share share-pinterest" title="Share by Email" target="_blank">
                                                <i class="fa fa-envelope" aria-hidden="true"></i> <span class="share-title" aria-hidden="true">Email</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                            <p id="freeShipMsg" class="freeShipMsg" data-price="199"><i class="fa fa-truck" aria-hidden="true"></i> GETTING CLOSER! ONLY <b class="freeShip"><span class="money" data-currency-usd="$199.00" data-currency="USD">$199.00</span></b> AWAY FROM <b>FREE SHIPPING!</b></p>
                            <p class="shippingMsg"><i class="fa fa-clock-o" aria-hidden="true"></i> ESTIMATED DELIVERY BETWEEN <b id="fromDate">Wed. May 1</b> and <b id="toDate">Tue. May 7</b>.</p>
                            <div class="userViewMsg" data-user="20" data-time="11000"><i class="fa fa-users" aria-hidden="true"></i> <strong class="uersView">14</strong> PEOPLE ARE LOOKING FOR THIS PRODUCT</div>
                        </div>
                        
                    </div>
                    <div class="tab-slider-product section">                            
                        <div class="tabs-listing" >
                            <ul class="tabs clearfix">
                                <li rel="tab1"><a class="tablink" style="margin-left:300px;">Product Details</a></li>
                                <li rel="tab2"><a class="tablink" style="margin-right:180px;">Reviews</a></li>                                            
                            </ul><br>
                            <div class="tab-container" style="margin-left:310px;">
                                <div id="tab1" class="tab_content">            
                                <h2>Product Details</h2>   
                                <table>                                                
                                    <tbody style="font-size:18px;">
                                    @foreach($productFilters as $filter)
                                    @if(isset($productDetails['category_id']))
                                        <?php
                                            $filterAvailable = ProductsFilter::filterAvailable($filter['id'],$productDetails['category_id']);        
                                        ?>
                                    @if($filterAvailable=="Yes")
                                        <tr>
                                            <th>{{ $filter['filter_name'] }}</th>
                                            <td>
                                                @foreach($filter['filter_values'] as $value)            
                                                    @if(!empty($productDetails[$filter['filter_column']]) && $value['filter_value']==$productDetails[$filter['filter_column']]) {{ ucwords($value['filter_value']) }} @endif
                                                @endforeach
                                            </td>                                                        
                                        </tr>
                                    @endif
                                    @endif
                                    @endforeach                                                    
                                        
                                    </tbody>
                                </table>                                      
                                </div>
                            </div>
                            <div class="tab_container" style="margin-left:340px;">
                                <div id="tab2" class="tab_content grid-products">
                                <div id="shopify-product-reviews">
                                    <div class="spr-container">                                        
                                        <div class="spr-content">
                                            <div class="spr-form clearfix">
                                                <form method="post" action="#" id="new-review-form" class="new-review-form">
                                                    <h3 class="spr-form-title">Write a review</h3>
                                                    <fieldset class="spr-form-contact">
                                                        <div class="spr-form-contact-name">
                                                        <label class="spr-form-label" for="review_author_10508262282">Name</label>
                                                        <input class="spr-form-input spr-form-input-text " id="review_author_10508262282" type="text" name="review[author]" value="" placeholder="Enter your name">
                                                        </div>
                                                        <div class="spr-form-contact-email">
                                                        <label class="spr-form-label" for="review_email_10508262282">Email</label>
                                                        <input class="spr-form-input spr-form-input-email " id="review_email_10508262282" type="email" name="review[email]" value="" placeholder="john.smith@example.com">
                                                        </div>
                                                    </fieldset>
                                                    <fieldset class="spr-form-review">
                                                    <div class="spr-form-review-rating">
                                                        <label class="spr-form-label">Rating</label>
                                                        <div class="spr-form-input spr-starrating">
                                                        <div class="product-review"><a class="reviewLink" href="#"><i class="fa fa-star-o"></i><i class="font-13 fa fa-star-o"></i><i class="font-13 fa fa-star-o"></i><i class="font-13 fa fa-star-o"></i><i class="font-13 fa fa-star-o"></i></a></div>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="spr-form-review-title">
                                                        <label class="spr-form-label" for="review_title_10508262282">Review Title</label>
                                                        <input class="spr-form-input spr-form-input-text " id="review_title_10508262282" type="text" name="review[title]" value="" placeholder="Give your review a title">
                                                    </div>
                                                
                                                    <div class="spr-form-review-body">
                                                        <label class="spr-form-label" for="review_body_10508262282">Body of Review <span class="spr-form-review-body-charactersremaining">(1500)</span></label>
                                                        <div class="spr-form-input">
                                                        <textarea class="spr-form-input spr-form-input-textarea " id="review_body_10508262282" data-product-id="10508262282" name="review[body]" rows="10" placeholder="Write your comments here"></textarea>
                                                        </div>
                                                    </div>
                                                    </fieldset>
                                                    <fieldset class="spr-form-actions">
                                                        <input type="submit" class="spr-button spr-button-primary button button-primary btn btn-primary" value="Submit Review">
                                                    </fieldset>
                                                </form>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div> 
                                        
                                </div>
                            </div>
                            
                        
                        </div>                                
                    </div>
                </div>
            </div>
            <!--End-product-single-->

              
            <!--Recenty View-->   
            <div class="tab-slider-product section">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="section-header text-center">
                                <h2 class="h2">Recently View</h2>
                            </div><hr>
                            <div class="tabs-listing">                                                         
                                <div class="tab_container">
                                    <div class="grid-products">
                                        <div class="productSlider">
                                            @foreach($recentlyViewedProducts as $product)
                                            <div class="col-12 item">
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

                                                    </a>
                                                    <!-- end product image -->
            
                                                    <!-- Start product button -->
                                                    <!-- <form class="variants add" action="#" onclick="window.location.href='cart.html'"method="post">
                                                        <button class="btn btn-addto-cart" type="button" tabindex="0">Select Options</button>
                                                    </form>
                                                    <div class="button-set">
                                                        <a href="javascript:void(0)" title="Quick View" class="quick-view-popup quick-view" data-toggle="modal" data-target="#content_quickview">
                                                            <i class="icon anm anm-search-plus-r"></i>
                                                        </a>
                                                        <div class="wishlist-btn">
                                                            <a class="wishlist add-to-wishlist" href="wishlist.html">
                                                                <i class="icon anm anm-heart-l"></i>
                                                            </a>
                                                        </div>
                                                        <div class="compare-btn">
                                                            <a class="compare add-to-compare" href="compare.html" title="Add to Compare">
                                                                <i class="icon anm anm-random-r"></i>
                                                            </a>
                                                        </div>
                                                    </div> -->
                                                    <!-- end product button -->
                                                </div>
                                                <!-- end product image -->
                                                <!--start product details -->
                                                <div class="product-details text-center">
                                                    <!-- product name -->
                                                    <div class="product-name">
                                                        <a href="short-description.html">{{ $product['product_name']}}</a>
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
                                                    
                                                    
                                                    <!-- Variant -->
                                                    
                                                    <!-- End Variant -->
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
            <!--End Recenty View-->

                
        </div>
    </div>
    <!--MainContent-->
</div>

@endsection