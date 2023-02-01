@extends('front.layout.layouts')
@section('content')
<!--Home slider-->
<div class="slideshow slideshow-wrapper pb-section">
    <div class="home-slideshow">
        @foreach($sliderBanners as $banner)
        <div class="slide slideshow--medium">         
            <div class="blur-up lazyload">
                <a @if(!empty($banner['link'])) href="{{url($banner['link'])}}" @else href="javascript" @endif>
                <img class="blur-up lazyload" data-src="{{ asset('uploads/image/banner/'.$banner['photo']) }}" src="{{ asset('uploads/image/banner/'.$banner['photo']) }}" alt="Outfit of Today" title="Outfit of Today" />
                </a>
                <div class="slideshow__text-wrap slideshow__overlay classic middle">
                    <div class="slideshow__text-content classic left">
                        <div class="container">
                            <div class="wrap-caption left">
                                <h2 class="h1 mega-title slideshow__title">{{ $banner['title'] }}</h2>
                                <span class="mega-subtitle slideshow__subtitle"></span>
                                <!-- <span class="btn">View Catelog</span> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
        @endforeach
        <!-- <div class="slide slideshow--medium">
            <div class="blur-up lazyload">
                <img class="blur-up lazyload" data-src="{{asset('user/assets/images/slideshow-banners/home12-category-banner2.jpg')}}" src="{{asset('user/assets/images/slideshow-banners/home12-category-banner2.jpg')}}" alt="Accessories" title="Accessories" />
                <div class="slideshow__text-wrap slideshow__overlay classic middle">
                    <div class="slideshow__text-content classic left">
                        <div class="container">
                            <div class="wrap-caption left">
                                <h2 class="h1 mega-title slideshow__title">Accessories</h2>
                                <span class="mega-subtitle slideshow__subtitle">New Collection A-W ss18</span>
                                <span class="btn">Shop now</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</div>
<!--End Home slider-->

<!-- Modals -->
@include('front.layout.modals')
<!-- End Modals -->


@endsection