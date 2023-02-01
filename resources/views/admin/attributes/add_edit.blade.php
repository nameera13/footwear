@extends('admin.master')
@section('admin')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Attributes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bi bi-house" style="color:gray;"></i></a></li>
              <li class="breadcrumb-item active">Attributes</li>
              <li class="breadcrumb-item active">AddAttributes</li>
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
                <h3 class="card-title">Add Attributes</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
             
              <form action="{{ url('admin/add-edit-attributes/'.$product['id'])}}" method="post" >
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
                        <div>
                            <input type="text" name="size[]" placeholder="Size" style="width: 120px;" required="" />
                            <input type="text" name="sku[]" placeholder="SKU" style="width: 120px;" required="" />
                            <input type="text" name="price[]" placeholder="Price" style="width: 120px;" required="" />
                            <input type="text" name="stock[]" placeholder="Stock" style="width: 120px;" required="" />
                            <a href="javascript:void(0);" class="add_button" title="Add Attributes">Add</a>
                        </div>
                    </div>

                  </div>
                
                </div>
                
                <div class="">&nbsp;
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Cancel</button>
                </div>
              </form><br>
              <div class="card-body">
              <h3 class="card-title"><b>Product Attributes</b></h3><br><br>
              <form action="{{ url('admin/edit-attributes/'.$product['id']) }}" method="post">
                @csrf
              
              <table id="pagination" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>S.N.</th>
                    <th>Size</th>
                    <th>SKU</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($product['attributes'] as $attribute)
                    <input style="display:none;" type="text" name="attributeId[]" value="{{ $attribute['id'] }}" required="" style="width: 70px;">
                  <tr>
                    <td>
                       {{$loop->iteration}} 
                    </td>
                    <td>
                      {{$attribute['size']}}
                    </td>
                    <td>
                      {{$attribute['sku']}}
                    </td>
                    <td>
                      <input type="number" name="price[]" value="{{$attribute['price']}}" required="" style="width:70px;">
                    </td>
                    <td>
                      <input type="number" name="stock[]" value="{{$attribute['stock']}}" required="" style="width:70px;">
                    </td>
                    <td>    
                        @if($attribute['status']==1)
                        <a class="updateAttributesStatus" id="attribute-{{$attribute['id']}}" attribute_id="{{$attribute['id']}}"  href="javascript:void(0)">
                            <i style="font-size: 18px;  margin-left:15px;" class="fas fa-bookmark " status="active"></i>
                        </a>
                        @else
                        <a class="updateAttributesStatus" id="attribute-{{$attribute['id']}}" attribute_id="{{$attribute['id']}}" href="javascript:void(0)" >
                            <i style="font-size: 18px;  margin-left:15px;" class="far fa-bookmark" status="inactive"></i>
                        </a>
                        @endif
                    </td> 
                  </tr>
                   @endforeach
                  </tbody>
              </table>
                <div class="">&nbsp;
                  <button type="submit" class="btn btn-primary">Update Attributes</button>
                </div>
              </form>
              </div>
          </div>

        </div>
    
      </div>
    </section>

@endsection