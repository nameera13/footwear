<?php use App\Models\Product; ?>
@extends('front.layout.layouts')
@section('content')
<div id="page-content">
    <!--Page Title-->
    <div class="page section-header text-center">
        <div class="page-title">
            <div class="wrapper"><h1 class="page-width">Thanks</h1></div>
        </div>
    </div>
    <!--End Page Title-->
    
    <div class="container" align="center">
        <h3>YOUR ORDER HAS BEEN PLACED SUCCESSFULLY</h3>  
        <p>Your order number is {{ Session::get('order_id') }} and Grand Total is INR
            {{ Session::get('grand_total') }}
        </p>    
    </div>
    
</div>
@endsection