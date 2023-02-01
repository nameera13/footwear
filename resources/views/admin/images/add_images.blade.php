@extends('admin.master')
@section('admin')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Images</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bi bi-house" style="color:gray;"></i></a></li>
              <li class="breadcrumb-item active">Images</li>
              <li class="breadcrumb-item active">AddImages</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Images</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
             
              <form action="{{ url('admin/add-images/'.$product['id'])}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  @if(Session::has('message'))
                  <div class="alert alert-info alert-dismissible fade show" role="alert">
                  <strong> {{ session::get('message') }} </strong>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                  @endif

                  @if(Session::has('error_message'))
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong> {{ session::get('error_message') }} </strong>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                  @endif

                  <div class="form-group">
                    <label for="product_name">Product Name</label>
                    &nbsp; {{ $product['product_name'] }}
                  </div>

                  <div class="form-group">
                    <label for="product_code">Product Code</label>
                    &nbsp; {{ $product['product_code'] }}
                  </div>

                  <div class="form-group">
                    <label for="product_color">Product Color</label>
                    &nbsp; {{ $product['product_color'] }}
                  </div>

                  <div class="form-group">
                    <label for="product_price">Product Price</label>
                    &nbsp; {{ $product['product_price'] }}
                  </div>
                         
                  <div class="form-group"> 
                    @if(!empty($product['product_image']))
                        <img style="width:120px;" src="{{ url('uploads/image/product/small/'.$product['product_image']) }}" >
                    @else
                        <img style="width:120px;" src="{{ url('uploads/image/product/small/no-image.png') }}" >
                    @endif
                  </div>

                  <div class="form-group">
                    <div class="field_wrapper">
                        <input type="file" name="image[]" multiple="" id="image" required="">    
                    </div>
                  </div>
                
                </div>
                
                <div class="">&nbsp;
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Cancel</button>
                </div>
              </form><br>
              <div class="card-body">
              <h3 class="card-title"><b>Product Images</b></h3><br><br>
             
              <table id="pagination" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                        <th>S.N.</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($product['images'] as $image)
                  <tr>
                    <td> {{$loop->iteration}} </td>
                    <td>
                        <img style="width:120px;" src="{{ url('uploads/image/product/small/'.$image['image']) }}" >
                    </td>
                    <td>    
                        @if($image['status']==1)
                        <a class="updateImageStatus" id="image-{{$image['id']}}" image_id="{{$image['id']}}"  href="javascript:void(0)">
                            <i style="font-size: 18px;  margin-left:15px;" class="fas fa-bookmark " status="active"></i>
                        </a>
                        @else
                        <a class="updateImageStatus" id="image-{{$image['id']}}" image_id="{{$image['id']}}" href="javascript:void(0)" >
                            <i style="font-size: 18px;  margin-left:15px;" class="far fa-bookmark" status="inactive"></i>
                        </a>
                        @endif
                        &nbsp;
                        <a href="{{route('deleteimage',$image['id'])}}" onclick="return confirm('Are you sure to delete Image?')"><i class="fas fa-trash" style="font-size: 20px; color:#D2042D;"></i></a> 
                    </td> 
                  </tr>
                   @endforeach
                   </tbody>
              </table>

             </div>
          </div>

        </div>
    
      </div>
    </section>


@endsection