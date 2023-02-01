@extends('admin.master')
@section('admin')

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h2>Products <a href="{{ url('/admin/add-edit-product') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-plus-circle"></i> Create Product</a></h2>

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><i class="bi bi-house" style="color:gray;"></i></a></li>
              <li class="breadcrumb-item active">Products</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    @if(Session::has('message'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong> {{ session::get('message') }} </strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Product List</h3>
                <p class="text-right">Total Product : {{\App\Models\Product::count()}}</p>
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
                <table id="pagination" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>S.N.</th>
                    <th>Product Name</th>
                    <th>Product Code</th>
                    <th>Product Color</th>
                    <th>Product Image</th>
                    <th>Category</th>
                    <th>Section</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($products as $product)
                  <tr>
                    <td> {{$loop->iteration}} </td>
                    <td>{{$product['product_name']}}</td>
                    <td>{{$product['product_code']}}</td>
                    <td>{{$product['product_color']}}</td>
                    <td>
                      @if(!empty($product['product_image']))
                        <img style="width: 150px; height: 100px;" src="{{ asset('uploads/image/product/small/'.$product['product_image']) }}">
                      @else
                      <img style="width: 150px; height: 100px;" src="{{ asset('uploads/image/product/small/no-image.png') }}">

                      @endif
                    </td>
                   
                    <td>{{$product['category']['category_name']}}</td>
                    <td>{{$product['section']['section_name']}}</td>
                    
                    <td>    
                        @if($product['status']==1)
                        <a class="updateproductStatus" id="product-{{$product['id']}}" product_id="{{$product['id']}}"  href="javascript:void(0)">
                            <i style="font-size: 18px;  margin-left:15px;" class="fas fa-bookmark " status="active"></i>
                        </a>
                        @else
                        <a class="updateproductStatus" id="product-{{$product['id']}}" product_id="{{$product['id']}}" href="javascript:void(0)" >
                            <i style="font-size: 18px;  margin-left:15px;" class="far fa-bookmark" status="inactive"></i>
                        </a>
                        @endif
                    </td> 
                    <td>
                        <a title="Edit Product" href="{{url('admin/add-edit-product/'.$product['id'])}}"><i class="fa fa-pencil-square-o" style="font-size: 20px; color:gray;"></i></a>
                        <a title="Add Attributes" href="{{url('admin/add-edit-attributes/'.$product['id'])}}"><i class="fa fa-plus-square" style="font-size: 20px; color:blue;"></i></a>
                        <a title="Add Image" href="{{url('admin/add-images/'.$product['id'])}}"><i class="fa fa-plus-circle" style="font-size: 20px; color:blue;"></i></a>
                        <a href="{{route('deleteproduct',$product['id'])}}" onclick="return confirm('Are you sure to delete Category?')"><i class="fas fa-trash" style="font-size: 20px; color:#D2042D;"></i></a> 
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