<!--Top Header-->
        <div class="top-header">
        <div class="container-fluid">
            <div class="row">
            	<div class="col-10 col-sm-8 col-md-5 col-lg-4">
                    <div class="currency-picker">
                        <span class="selected-currency">USD</span>
                        <ul id="currencies">
                            <li data-currency="INR" class="">INR</li>
                            <li data-currency="GBP" class="">GBP</li>
                            <li data-currency="CAD" class="">CAD</li>
                            <li data-currency="USD" class="selected">USD</li>
                            <li data-currency="AUD" class="">AUD</li>
                            <li data-currency="EUR" class="">EUR</li>
                            <li data-currency="JPY" class="">JPY</li>
                        </ul>
                    </div>
                    <div class="language-dropdown">
                        <span class="language-dd">English</span>
                        <ul id="language">
                            <li class="">German</li>
                            <li class="">French</li>
                        </ul>
                    </div>
                    
                    <p class="phone-no"><i class="anm anm-phone-s"></i> +440 0(111) 044 833</p>
                    
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 d-none d-lg-none d-md-block d-lg-block">
                	<div class="text-center"><p class="top-header_middle-text"> Worldwide Express Shipping</p></div>
                </div>
                <div class="col-2 col-sm-4 col-md-3 col-lg-4 text-right">
                    <div class="account-dropdown">
                        <span class="account-dd"> @if(Auth::check())  {{auth()->user()->firstname}} @else My Account  @endif</span>
                        <ul id="account">
                            <a href="{{url('cart')}}"><li class="">My&nbsp;Cart&nbsp;&nbsp;</li></a>
                            <a href=""><li class="">My&nbsp;Wishlist</li></a>
                            <!-- <a href=""><li class="">Checkout&nbsp;</li></a> -->
                            @if(Auth::check())   
                                <!-- <a href="#"><li class="">My&nbsp;Account&nbsp;&nbsp;</li></a>     -->                                
                                <a href="{{ url('orders') }}"><li class="">My&nbsp;Order&nbsp;&nbsp;</li></a>    
                                <a href="{{ route('logout') }}" onclick="return confirm('Are you sure to Logout!')"><li class="">Logout&nbsp;&nbsp;&nbsp;&nbsp;</li></a>                                  
                            @else                                               
                                <a href="{{ route('login') }}"><li class="">Login&nbsp;&nbsp;&nbsp;&nbsp;</li></a>   
                            @endif                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!--End Top Header-->
        <!--Header-->
        <?php
            use App\Models\Section;
            $sections = Section::sections();
            // echo"<pre>"; print_r($sections); die;
            $totalCartItems = totalCartItems();
        ?>

        <div class="header-wrap animated d-flex">
            <div class="container-fluid">        
                <div class="row align-items-center">
                    <!--Desktop Logo-->
                    <div class="logo col-md-2 col-lg-2 d-none d-lg-block">
                        <a href="index.html">
                            <img src="{{asset('user/assets/images/logo.svg')}}" alt="Belle Multipurpose Html Template" title="Belle Multipurpose Html Template" />
                        </a>
                    </div>
                    <!--End Desktop Logo-->
                    <div class="col-2 col-sm-3 col-md-3 col-lg-8">
                        <div class="d-block d-lg-none">
                            <button type="button" class="btn--link site-header__menu js-mobile-nav-toggle mobile-nav--open">
                                <i class="icon anm anm-times-l"></i>
                                <i class="anm anm-bars-r"></i>
                            </button>
                        </div>
                        <!--Desktop Menu-->
                        <nav class="grid__item" id="AccessibleNav"><!-- for mobile -->
                            <ul id="siteNav" class="site-nav medium center hidearrow">
                                <li class="lvl1 parent megamenu"><a href="/">Home <i class="anm anm-angle-down-l"></i></a>
                                    
                                </li>                                
                                <li class="lvl1 parent megamenu"><a href="#">All Category <i class="anm anm-angle-down-l"></i></a>
                                    <div class="megamenu style4">
                                        <ul class="grid grid--uniform mmWrapper">
                                            @foreach($sections as $section)
                                                @if(count($section['categories'])>0)
                                                <li class="grid__item lvl-1 col-md-3 col-lg-3"><a href="#" class="site-nav lvl-1">{{$section['section_name']}}</a>
                                                    
                                                    <ul class="subLinks">
                                                    @foreach($section['categories'] as $category)                                
                                                        <li class="lvl-2"><a href="{{url($category['url'])}}" class="site-nav lvl-2">{{$category['category_name']}}</a>
                                                        
                                                        <ul class="subLinks">
                                                        @foreach($category['subcategories'] as $subcategory)
                                                            <li class="lvl-2"><a href="{{url($subcategory['url'])}}" class="site-nav lvl-2">&nbsp;&nbsp;&raquo;&nbsp;{{$subcategory['category_name']}}</a>
                                                        @endforeach
                                                        </ul>                                                    

                                                        </li>
                                                    @endforeach
                                                </ul>
                                                </li>
                                                @endif
                                            @endforeach                                            
                                            <li class="grid__item lvl-1 col-md-3 col-lg-3">
                                                <a href="#"><img style="height: 200px; width:350px;" src="{{asset('user/assets/images/megamenu-bg1.jpg')}}" alt="" title="" /></a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                @foreach($sections as $section)
                                @if(count($section['categories'])>0)
                                    <li class="lvl1 parent megamenu"><a href="#">{{$section['section_name']}} <i class="anm anm-angle-down-l"></i></a>
                                        <div class="megamenu style4">
                                            <ul class="grid grid--uniform mmWrapper">
                                                @foreach($section['categories'] as $category)
                                                <li class="grid__item lvl-1 col-md-3 col-lg-3"><a href="#" class="site-nav lvl-1"></a>                                            
                                                    <ul class="subLinks">                                                                            
                                                        <li class="lvl-2"><a href="{{url($category['url'])}}" class="site-nav lvl-2">{{$category['category_name']}}</a>                                                    
                                                            <ul class="subLinks">
                                                                @foreach($category['subcategories'] as $subcategory)
                                                                    <li class="lvl-2"><a href="{{url($subcategory['url'])}}" class="site-nav lvl-2">&nbsp;&nbsp;&raquo;&nbsp;{{$subcategory['category_name']}}</a>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                </ul>                                              
                                                </li>
                                                @endforeach                                    
                                                <li class="grid__item lvl-1 col-md-6 col-lg-6">
                                                    <a href="#"><img style="" src="{{asset('user/assets/images/megamenu-bg1.jpg')}}" alt="" title="" /></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                @endif
                                @endforeach  
                                <!-- <li class="lvl1 parent megamenu"><a href="#">Blog <i class="anm anm-angle-down-l"></i></a>  
                                </li> -->
                            </ul>
                        </nav>
                        <!--End Desktop Menu-->
                    </div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-2 d-block d-lg-none mobile-logo">
                        <div class="logo">
                            <a href="index.html">
                                <img src="{{asset('user/assets/images/logo.svg')}}" alt="Belle Multipurpose Html Template" title="Belle Multipurpose Html Template" />
                            </a>
                        </div>
                    </div>
                    <div class="col-4 col-sm-3 col-md-3 col-lg-2">
                        <div class="site-cart">
                            <a href="#" class="site-header__cart" style="font-size:22px; text-decoration:none;" title="Cart">
                                <i class="icon anm anm-bag-l" ></i>
                                <span id="CartCount" class="site-header__cart-count totalCartItems" data-cart-render="item_count">{{ $totalCartItems }}</span>
                            </a>
                            <!--Minicart Popup-->
                           <div id="appendHeaderCartItems">
                                @include('front.layout.header_cart_items')
                           </div>
                            <!--EndMinicart Popup-->
                        </div>
                        <div class="site-header__search">
                            <button type="button" class="search-trigger"><i class="icon anm anm-search-l"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End Header-->