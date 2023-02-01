@extends('admin.master')
@section('admin')

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h2>Orders</h2>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><i class="bi bi-house" style="color:gray;"></i></a></li>
              <li class="breadcrumb-item active">Orders</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Order List</h3>
                <p class="text-right">Total Orders : {{\App\Models\Order::count()}}</p>
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
                <table id="pagination" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Ordered Products</th>
                    <th>Order Amount</th>
                    <th>Order Status</th>
                    <th>Payment Method</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($orders as $order)
                  <tr>
                    <td> {{$loop->iteration}} </td>
                    <td> {{ date('Y-m-d h:i:s', strtotime($order['created_at'])); }} </td>
                    <td> {{ucfirst($order['firstname'])}}&nbsp;{{ucfirst($order['lastname'])}}</td>
                    <td> {{$order['email']}} </td>
                    <td> 
                        @foreach($order['orders_products'] as $product)
                            {{ $product['product_code'] }} ({{ $product['product_qty'] }}) <br>
                        @endforeach
                    </td>
                    <td> {{ $order['grand_total'] }} </td>
                    <td> {{ $order['order_status'] }} </td>
                    <td> {{ $order['payment_method'] }} </td>
                    <td>
                        <a title="View Order Detail" href="{{ url('admin/order/'.$order['id']) }}"><i class="fa fa-file-text" style="color:gray;"></i></a> |
                        <a href="" onclick="return confirm('are you sure to delete?')"><i class="bi bi-trash" style="color: #cc0000;"></i></a>
                    </td>
                  </tr>
                   @endforeach
                  </tbody>
                </table>
              </div> 
            </div>  
          </div>  
        </div> 
      </div>

    </section>

@endsection