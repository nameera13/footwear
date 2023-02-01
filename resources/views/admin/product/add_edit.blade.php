@extends('admin.master')
@section('admin')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $title }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bi bi-house" style="color:gray;"></i></a></li>
              <li class="breadcrumb-item active">Product</li>
              <li class="breadcrumb-item active">{{ $title }}</li>
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
                <h3 class="card-title">Product</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
             
              <form  @if(empty($product['id'])) action="{{url('admin/add-edit-product')}}" @else action="{{ url('admin/add-edit-product/'.$product['id'])}}" @endif method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                @if(Session::has('message'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                  <strong> {{ session::get('message') }} </strong>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif
                  <div class="form-group">
                    <label for="category_id">Select Category</label>
                    <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                        <option value="">Select</option>
                        @foreach($categories as $section)
                            <optgroup label="{{ $section['section_name']}}" style="color:#313131"></optgroup>
                            @foreach($section['categories'] as $category)
                                <option @if(!empty($product['category_id']==$category['id'])) selected="" @endif value="{{$category['id']}}">&nbsp;&nbsp;&nbsp;&raquo;&nbsp;{{$category['category_name']}}</option>
                                @foreach($category['subcategories'] as $subcategory)
                                    <option @if(!empty($product['category_id']==$subcategory['id'])) selected="" @endif value="{{$subcategory['id']}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&raquo;&nbsp;{{$subcategory['category_name']}}</option>
                                @endforeach
                            @endforeach
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>

                  <div class="loadFilters">
                      @include('admin.filter.category_filters')
                  </div>

                  <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input type="text" class="form-control @error('product_name') is-invalid @enderror" id="product_name" name="product_name" placeholder="Product Name" @if(!empty($product['product_name'])) value="{{ $product['product_name']}}" @else :value="{{old('product_name')}}" @endif>
                    @error('product_name')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="product_code">Product Code</label>
                    <input type="text" class="form-control @error('product_code') is-invalid @enderror" id="product_code" name="product_code" placeholder="Product Code" @if(!empty($product['product_code'])) value="{{ $product['product_code']}}" @else :value="{{old('product_code')}}" @endif>
                    @error('product_code')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="product_color">Product Color</label>
                    <input type="text" class="form-control @error('product_color') is-invalid @enderror" id="product_color" name="product_color" placeholder="Product Color" @if(!empty($product['product_color'])) value="{{ $product['product_color']}}" @else :value="{{old('product_color')}}" @endif>
                    @error('product_color')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="product_price">Product Price</label>
                    <input type="text" class="form-control @error('product_price') is-invalid @enderror" id="product_price" name="product_price" placeholder="Product Price" @if(!empty($product['product_price'])) value="{{ $product['product_price']}}" @else :value="{{old('product_price')}}" @endif>
                    @error('product_price')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>
                  
                  <div class="form-group">
                    <label for="product_discount">Product Discount (%)</label>
                    <input type="text" class="form-control @error('product_discount') is-invalid @enderror" id="product_discount" name="product_discount" placeholder="Product Discount" @if(!empty($product['product_discount'])) value="{{ $product['product_discount']}}" @else :value="{{old('product_discount')}}" @endif>
                    @error('product_discount')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="product_weight">Product Weight</label>
                    <input type="text" class="form-control @error('product_weight') is-invalid @enderror" id="product_weight" name="product_weight" placeholder="Product Weight" @if(!empty($product['product_weight'])) value="{{ $product['product_weight']}}" @else :value="{{old('product_weight')}}" @endif>
                    @error('product_weight')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="group_code">Group Code</label>
                    <input type="text" class="form-control @error('group_code') is-invalid @enderror" id="group_code" name="group_code" placeholder="Group Code" @if(!empty($product['group_code'])) value="{{ $product['group_code']}}" @else :value="{{old('group_code')}}" @endif>
                    @error('group_code')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="product_image">Product Image</label>
                    <input type="file" class="form-control @error('product_image') is-invalid @enderror" id="product_image" name="product_image" >
                    @error('product_image')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror

                    @if(!empty($product['product_image']))
                    <a target="_blank" href="{{url('uploads/image/product/large/'.$product['product_image'])}}" class="link-info">View Image</a>&nbsp;&nbsp;|&nbsp;
                    <a href="{{route('delete-product-image',$product['id'])}}" class="link-info" onclick="return confirm('Are you sure to Delete?')">Delete Image</a>
                    @endif

                  </div>

                  <div class="form-group">
                    <label for="product_video">Product Video</label>
                    <input type="file" class="form-control @error('product_video') is-invalid @enderror" id="product_video" name="product_video" >
                    @error('product_video')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror

                    @if(!empty($product['product_video']))
                    <a target="_blank" href="{{url('uploads/video/product/'.$product['product_video'])}}" class="link-info">View Video</a>&nbsp;&nbsp;|&nbsp;
                    <a href="{{route('delete-product-video',$product['id'])}}" class="link-info" onclick="return confirm('Are you sure to Delete?')">Delete Video</a>
                    @endif

                  </div>

                  <div class="form-group">
                    <label for="description">Product Description</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ $product['description'] }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="meta_title">Meta Title</label>
                    <input type="text" class="form-control @error('meta_title') is-invalid @enderror" id="meta_title" name="meta_title" placeholder="Meta Title" @if(!empty($product['meta_title'])) value="{{ $product['meta_title']}}" @else :value="{{old('meta_title')}}" @endif>
                    @error('meta_title')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="meta_description">Meta Description</label>
                    <input type="text" class="form-control @error('meta_description') is-invalid @enderror" id="meta_description" name="meta_description" placeholder="Meta Description" @if(!empty($product['meta_description'])) value="{{ $product['meta_description']}}" @else :value="{{old('meta_description')}}" @endif>
                    @error('meta_description')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="meta_keywords">Meta Keywords</label>
                    <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" id="meta_keywords" name="meta_keywords" placeholder="Meta Keywords" @if(!empty($product['meta_keywords'])) value="{{ $product['meta_keywords']}}" @else :value="{{old('meta_keywords')}}" @endif>
                    @error('meta_keywords')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="is_featured">Featured Items</label>
                    <input type="checkbox" id="is_featured" name="is_featured" value="Yes" 
                    @if(!empty($product['is_featured']) && $product['is_featured']=="Yes")checked="" @endif>
                    @error('is_featured')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror

                  </div>

                  <div class="form-group">
                    <label for="is_bestseller">Best Seller Items</label>
                    <input type="checkbox" id="is_bestseller" name="is_bestseller" value="Yes" 
                    @if(!empty($product['is_bestseller']) && $product['is_bestseller']=="Yes")checked="" @endif>
                    @error('is_bestseller')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror

                  </div>

                </div>

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>

        </div>
    
      </div>
    </section>

@endsection