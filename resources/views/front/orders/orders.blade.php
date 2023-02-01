@extends('front.layout.layouts')
@section('content')
<div id="page-content">
    <!--Page Title-->
    <div class="page section-header text-center">
        <div class="page-title">
            <div class="wrapper"><h1 class="page-width">Orders</h1></div>
        </div>
    </div>
    <!--End Page Title-->
    
    <div class="container">
        <div class="table-responsive-sm order-table"> 
            <table class="bg-white table table-bordered table-hover text-center">
                <thead>
                    <tr>
                        <th class="text-left">Order ID</th>
                        <th>Ordered Products</th>                                           
                        <th>Payment Method</th>
                        <th>Grand Total</th>                                            
                        <th>Create On</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td><a href="{{ url('orders/'.$order['id']) }}">{{ $order['id'] }}</a></td>
                        <td>
                            @foreach($order['orders_products'] as $product)
                                {{ $product['product_code'] }} <br>
                            @endforeach
                        </td>
                        <td>{{ $order['payment_method'] }}</td>
                        <td>{{ $order['grand_total'] }}</td>
                        <td>{{ date('Y-m-d h:i:s', strtotime($order['created_at'])); }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
</div>
@endsection