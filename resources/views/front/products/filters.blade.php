<?php 
    use App\Models\ProductsFilter; 
    use App\Models\Section;
    $productFilters = ProductsFilter::productFilters();
    $sections = Section::sections();
    // echo"<pre>"; print_r($sections); die;
    $totalCartItems = totalCartItems();

?>
<div class="col-12 col-sm-12 col-md-3 col-lg-3 sidebar filterbar">
    <div class="closeFilter d-block d-md-none d-lg-none"><i class="icon icon anm anm-times-l"></i></div>
    <div class="sidebar_tags">
        <div class="category-description">
        
        </div>
        <!--Categories-->
        <div class="sidebar_widget categories filter-widget">
            <div class="widget-title"><h2>Categories</h2></div>
            <div class="widget-content">
                <ul class="sidebar_categories">
                @foreach($sections as $section)
                @if(count($section['categories'])>0)
                    <li class="level1 sub-level"><a href="#;" class="site-nav">{{$section['section_name']}}</a>
                        <ul class="sublinks">
                        @foreach($section['categories'] as $category) 
                            <li class="level2 "><a href="{{url($category['url'])}}" class="site-nav">{{$category['category_name']}}</a></li>    
                        @endforeach
                        </ul>
                    </li>
                @endif
                @endforeach                     
                </ul>
            </div>
        </div>
        <!--Categories-->
        
        <!--Size Swatches-->
        <?php $getSizes = ProductsFilter::getSizes($url); ?>
        <div class="sidebar_widget filterBox filter-widget">
            <div class="widget-title"><h2>Size</h2></div>
            <div class="filter-color swacth-list">
                <ul>
                    <!-- <li><span class="swacth-btn"style="margin-right:250px;">X</span></li> -->
                    @foreach($getSizes as $key => $size)
                    <li>
                        <input type="checkbox" class="check-box size" name="size[]" id="size{{ $key }}" value="{{ $size }}">
                        <label for="size{{ $key }}"><span><span></span></span>{{ $size }}</label>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <!--End Size Swatches-->
        <!--Color Swatches-->
        <?php $getColors = ProductsFilter::getColors($url); ?>
        <div class="sidebar_widget filterBox filter-widget">
            <div class="widget-title"><h2>Color</h2></div>
            <div class="filter-color swacth-list clearfix">
                <ul>
                    @foreach($getColors as $key => $color)
                    <li>
                        <input type="checkbox" class="check-box color" name="color[]" id="color{{ $key }}" value="{{ $color }}">
                        <label for="color{{ $key }}"><span><span></span></span>{{ $color }}</label>
                    </li>
                    @endforeach
                </ul> 
            </div>
        </div>
        <!--End Color Swatches-->
        
        <!--Filter-->
        @foreach($productFilters as $filter)
        <?php
            $filterAvailable = ProductsFilter::filterAvailable($filter['id'],$categoryDetails['categoryDetails']['id']);        
        ?>
        @if($filterAvailable=="Yes")
        @if(count($filter['filter_values'])>0)
        <div class="sidebar_widget filterBox filter-widget">
            <div class="widget-title"><h2>{{ $filter['filter_name'] }}</h2></div>
            <ul>
                @foreach($filter['filter_values'] as $value)
                <li>
                    <input type="checkbox" class="check-box {{ $filter['filter_column'] }}" name="{{ $filter['filter_column'] }}[]" id="{{ $value['filter_value']}}" value="{{ $value['filter_value']}}">
                    <label for="{{ $value['filter_value']}}"><span><span></span></span>{{ ucwords($value['filter_value']) }}</label>
                </li>
                @endforeach
            </ul>
        </div>
        @endif
        @endif
        @endforeach
        <!--End Filter-->

        <!--Price Filter-->
        <div class="sidebar_widget filterBox filter-widget">
            <div class="widget-title"><h2>Price</h2></div>
            <div class="filter-price swacth-list clearfix">
                <ul>
                    <?php $prices = array('0-1000','1000-2000','2000-5000','5000-10000','10000-100000'); ?>
                    @foreach($prices as $key => $price)
                    <li>
                        <input type="checkbox" class="check-box price" name="price[]" id="price{{ $key }}" value="{{ $price }}">
                        <label for="price{{ $key }}"><span><span></span></span>Rs. {{ $price }}</label>
                    </li>
                   @endforeach
                </ul> 
            </div>
        </div>
        <!--End Price Filter-->
        <!--Popular Products-->
        <!-- <div class="sidebar_widget">
            <div class="widget-title"><h2>Popular Products</h2></div>
            <div class="widget-content">
                <div class="list list-sidebar-products">
                    <div class="grid">
                    <div class="grid__item">
                        <div class="mini-list-item">
                        <div class="mini-view_image">
                            <a class="grid-view-item__link" href="#">
                                <img class="grid-view-item__image" src="{{asset('user/assets/images/product-images/mini-product-img.jpg')}}" alt="" />
                            </a>
                        </div>
                        <div class="details"> <a class="grid-view-item__title" href="#">Cena Skirt</a>
                            <div class="grid-view-item__meta"><span class="product-price__price"><span class="money">$173.60</span></span></div>
                        </div>
                        </div>
                    </div>
                    <div class="grid__item">
                        <div class="mini-list-item">
                        <div class="mini-view_image"> <a class="grid-view-item__link" href="#"><img class="grid-view-item__image" src="{{asset('user/assets/images/product-images/mini-product-img1.jpg')}}" alt="" /></a> </div>
                        <div class="details"> <a class="grid-view-item__title" href="#">Block Button Up</a>
                            <div class="grid-view-item__meta"><span class="product-price__price"><span class="money">$378.00</span></span></div>
                        </div>
                        </div>
                    </div>
                    <div class="grid__item">
                        <div class="mini-list-item">
                        <div class="mini-view_image"> <a class="grid-view-item__link" href="#"><img class="grid-view-item__image" src="{{asset('user/assets/images/product-images/mini-product-img2.jpg')}}" alt="" /></a> </div>
                        <div class="details"> <a class="grid-view-item__title" href="#">Balda Button Pant</a>
                            <div class="grid-view-item__meta"><span class="product-price__price"><span class="money">$278.60</span></span></div>
                        </div>
                        </div>
                    </div>
                    <div class="grid__item">
                        <div class="mini-list-item">
                        <div class="mini-view_image"> <a class="grid-view-item__link" href="#"><img class="grid-view-item__image" src="{{asset('user/assets/images/product-images/mini-product-img3.jpg')}}" alt="" /></a> </div>
                        <div class="details"> <a class="grid-view-item__title" href="#">Border Dress in Black/Silver</a>
                            <div class="grid-view-item__meta"><span class="product-price__price"><span class="money">$228.00</span></span></div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!--End Popular Products-->
        
        <!--Information-->
        <!-- <div class="sidebar_widget">
            <div class="widget-title"><h2>Information</h2></div>
            <div class="widget-content"><p>Use this text to share information about your brand with your customers. Describe a product, share announcements, or welcome customers to your store.</p></div>
        </div> -->
        <!--end Information-->
        <!--Product Tags-->
        <?php /* <div class="sidebar_widget">
            <div class="widget-title">
            <h2>Product Tags</h2>
            </div>
            <div class="widget-content">
            <ul class="product-tags">
                <li><a href="#" title="Show products matching tag $100 - $400">$100 - $400</a></li>
                <li><a href="#" title="Show products matching tag $400 - $600">$400 - $600</a></li>
                <li><a href="#" title="Show products matching tag $600 - $800">$600 - $800</a></li>
                <li><a href="#" title="Show products matching tag Above $800">Above $800</a></li>
                <li><a href="#" title="Show products matching tag Allen Vela">Allen Vela</a></li>
                <li><a href="#" title="Show products matching tag Black">Black</a></li>
                <li><a href="#" title="Show products matching tag Blue">Blue</a></li>
                <li><a href="#" title="Show products matching tag Cantitate">Cantitate</a></li>
                <li><a href="#" title="Show products matching tag Famiza">Famiza</a></li>
                <li><a href="#" title="Show products matching tag Gray">Gray</a></li>
                <li><a href="#" title="Show products matching tag Green">Green</a></li>
                <li><a href="#" title="Show products matching tag Hot">Hot</a></li>
                <li><a href="#" title="Show products matching tag jean shop">jean shop</a></li>
                <li><a href="#" title="Show products matching tag jesse kamm">jesse kamm</a></li>
                <li><a href="#" title="Show products matching tag L">L</a></li>
                <li><a href="#" title="Show products matching tag Lardini">Lardini</a></li>
                <li><a href="#" title="Show products matching tag lareida">lareida</a></li>
                <li><a href="#" title="Show products matching tag Lirisla">Lirisla</a></li>
                <li><a href="#" title="Show products matching tag M">M</a></li>
                <li><a href="#" title="Show products matching tag mini-dress">mini-dress</a></li>
                <li><a href="#" title="Show products matching tag Monark">Monark</a></li>
                <li><a href="#" title="Show products matching tag Navy">Navy</a></li>
                <li><a href="#" title="Show products matching tag new">new</a></li>
                <li><a href="#" title="Show products matching tag new arrivals">new arrivals</a></li>
                <li><a href="#" title="Show products matching tag Orange">Orange</a></li>
                <li><a href="#" title="Show products matching tag oxford">oxford</a></li>
                <li><a href="#" title="Show products matching tag Oxymat">Oxymat</a></li>
            </ul>
            <span class="btn btn--small btnview">View all</span> </div>
        </div> */?>
        <!--end Product Tags-->
    </div>
</div>