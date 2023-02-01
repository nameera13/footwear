<?php use App\Models\Product; ?>
@extends('front.layout.layouts')
@section('content')

<!--Body Content-->
<div id="page-content">
    <!--Collection Banner-->
    <div class="collection-header">
        <div class="collection-hero">
            <div class="collection-hero__image"><img class="blur-up lazyload" data-src="{{asset('user/assets/images/cat-women2.jpg')}}" src="{{asset('user/assets/images/cat-women2.jpg')}}" alt="Women" title="Women" /></div>
            <div class="collection-hero__title-wrapper"><h1 class="collection-hero__title page-width">Shop</h1></div>
        </div>
    </div>
    <!--End Collection Banner-->
    &nbsp;
        
    <div class="container">
        <div class="row">
            <!--Sidebar-->
            @include('front.products.filters')
            <!--End Sidebar-->
            <!--Main Content-->
            <div class="col-12 col-sm-12 col-md-9 col-lg-9 main-col">
                <div class="category-description">
                <div class="bredcrumbWrap">
                    <div class="container breadcrumbs">
                        <a href="{{url('/')}}" title="Back to the home page">Home</a><span aria-hidden="true">›</span><?php echo $categoryDetails['breadcrumbs']; ?>
                    </div>
                </div>
                </div>
                
                <div class="productList">
                    <!--Toolbar-->
                    <button type="button" class="btn btn-filter d-block d-md-none d-lg-none"> Product Filters</button>
                    <div class="toolbar">
                        <div class="filters-toolbar-wrapper">
                            <div class="row">
                                <div class="col-4 col-md-4 col-lg-4 filters-toolbar__item collection-view-as d-flex justify-content-start align-items-center">
                                    <a href="" title="Grid View" class="change-view change-view--active">
                                        <img src="{{asset('user/assets/images/grid.jpg')}}" alt="Grid" />
                                    </a>
                                    <a href="" title="List View" class="change-view">
                                        <img src="{{asset('user/assets/images/list.jpg')}}" alt="List" />
                                    </a>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4 text-center filters-toolbar__item filters-toolbar__item--count d-flex justify-content-center align-items-center">
                                    <!-- <span class="filters-toolbar__product-count">Showing: 22</span> -->
                                    <div class="filters-toolbar__item">
                                        <label for="SortBy" class="hidden">Showing</label>
                                        <select name="SortBy" id="SortBy" class="filters-toolbar__input filters-toolbar__input--sort">
                                            <option value="title-ascending" selected="selected">Showing:&nbsp;{{ count($categoryProducts) }}</option>
                                            <option value="title-ascending">Showing:&nbsp;All&nbsp;&nbsp;&nbsp;</option>
                                            
                                        </select>
                                        <input class="collection-header__default-sort" type="hidden" value="manual">
                                    </div>
                                </div>
                                
                                    <div class="col-4 col-md-4 col-lg-4 text-right">
                                    <form action="" name="sortProducts" id="sortProducts">
                                        <input type="hidden" name="url" id="url" value="{{ $url }}">
                                        <div class="filters-toolbar__item">
                                            <label for="SortBy" class="hidden">Sort</label>
                                            <select name="sort" id="sort" class="filters-toolbar__input filters-toolbar__input--sort">
                                                <!-- <option value="title-ascending" selected="selected">Sort</option> -->
                                                <option selected="" value="">Select</option>
                                                <option value="product_latest" @if(isset($_GET['sort']) && $_GET['sort']=="product_latest") selected="" @endif>Sort By : Latest</option>
                                                <option value="price_lowest" @if(isset($_GET['sort']) && $_GET['sort']=="price_lowest") selected="" @endif>Sort By : Lowest Price</option>
                                                <option value="price_highest" @if(isset($_GET['sort']) && $_GET['sort']=="price_highest") selected="" @endif>Sort By : Highest Price   </option>
                                                <option value="name_a_z" @if(isset($_GET['sort']) && $_GET['sort']=="name_a_z") selected="" @endif>Sort By : Name A-Z</option>
                                                <option value="name_z_a" @if(isset($_GET['sort']) && $_GET['sort']=="name_z_a") selected="" @endif>Sort By : Name Z-A</option>
                                                
                                            </select>
                                            <!-- <input class="collection-header__default-sort" type="hidden" value="manual"> -->
                                        </div>
                                    </form>
                                    </div>
                               

                            </div>
                        </div>
                    </div>
                    <!--End Toolbar-->
                    <div class="filter_products">
                        @include('front.products.ajax_products_listing')
                    </div>
                </div>
                <hr class="clear">
                @if(isset($_GET['sort']))
                <div>{{$categoryProducts->appends(['sort'=>$_GET['sort']])->links()}}</div>
                @else
                <div>{{$categoryProducts->links()}}</div>
                @endif
                <div> {{ $categoryDetails['categoryDetails']['description'] }} </div>

            <?php /*    <div class="pagination">
                    <ul>
                    <li class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li class="next"><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i></a></li>
                    </ul>
                </div>*/ ?>

                
            </div>
            <!--End Main Content-->
        </div>
    </div>

</div>
<!--End Body Content-->

@endsection