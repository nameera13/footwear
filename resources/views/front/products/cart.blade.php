<?php use App\Models\Product; ?>
@extends('front.layout.layouts')
@section('content')
<div id="page-content">
    <!--Page Title-->
    <div class="page section-header text-center">
        <div class="page-title">
            <div class="wrapper"><h1 class="page-width">Shopping Cart</h1></div>
        </div>
    </div>
    <!--End Page Title-->
    
    <div class="container">
      
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

      <div id="appendCartItems">
        @include('front.products.cart_items')
      </div>        
    </div>
    
</div>
@endsection