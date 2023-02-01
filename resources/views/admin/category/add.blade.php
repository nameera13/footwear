@extends('admin.master')
@section('admin')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Category</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bi bi-house" style="color:gray;"></i></a></li>
              <li class="breadcrumb-item active">Category</li>
              <li class="breadcrumb-item active">AddCategory</li>
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
                <h3 class="card-title">Category</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
             
              <form action="{{route('storecategory')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="category_name">Category Name</label>
                    <input type="text" class="form-control @error('category_name') is-invalid @enderror" id="category_name" name="category_name">
                    @error('category_name')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="section_id">Select Section</label>
                    <select name="section_id" id="section_id" class="form-control @error('section_id') is-invalid @enderror">
                        <option value="">Select</option>
                        @foreach($sections as $section)
                            <option value="{{ $section['id'] }}">{{ $section['section_name']}}</option>
                        @endforeach
                    </select>
                    @error('section_id')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>

                  <div id="appendCategoriesLevel">
                    @include('admin.category.append_categories_level')
                  </div>

                  <div class="form-group">
                    <label for="category_image">Category Image</label>
                    <input type="file" class="form-control @error('category_image') is-invalid @enderror" id="category_image" name="category_image" >
                    @error('category_image')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="category_discount">Category Discount</label>
                    <input type="text" class="form-control @error('category_discount') is-invalid @enderror" id="category_discount" name="category_discount" placeholder="Category Discount" :value="{{old('category_discount')}}">
                    @error('category_discount')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="description">Category Description</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"></textarea>
                    @error('description')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>
                  
                  <div class="form-group">
                    <label for="url">Category URL</label>
                    <input type="text" class="form-control @error('url') is-invalid @enderror" id="url" name="url" placeholder="URL" :value="{{old('url')}}">
                    @error('url')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="meta_title">Meta Title</label>
                    <input type="text" class="form-control @error('meta_title') is-invalid @enderror" id="meta_title" name="meta_title" placeholder="Meta Title" :value="{{old('meta_title')}}">
                    @error('meta_title')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="meta_description">Meta Description</label>
                    <input type="text" class="form-control @error('meta_description') is-invalid @enderror" id="meta_description" name="meta_description" placeholder="Meta Description" :value="{{old('meta_description')}}">
                    @error('meta_description')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="meta_keywords">Meta Keywords</label>
                    <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" id="meta_keywords" name="meta_keywords" placeholder="Meta Keywords" :value="{{old('meta_keywords')}}">
                    @error('meta_keywords')
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script>
      
      $(document).ready(function(){
        
          $("#section_id").change(function(){
              var section_id = $(this).val();
              $.ajax({
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type:'get',
                    url:"{{route('append-categories-level')}}",
                    data:{section_id:section_id},
                    success:function(resp){
                        $('#appendCategoriesLevel').html(resp);
                    },error:function(){
                        alert("Error"); 
                    }



              })
          });


      });

    </script>
@endsection