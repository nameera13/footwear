@extends('admin.master')
@section('admin')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Category</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bi bi-house" style="color:gray;"></i></a></li>
              <li class="breadcrumb-item active">EditCategory</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
        @if(Session::has('message'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong> {{ session::get('message') }} </strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Category</h3>
              </div>
              
              <form action="{{ route('updatecategory') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="{{$categories['id']}}" name="category_id">
                <div class="card-body">
                  <div class="form-group">
                    <label for="category_name">Category Name</label>
                    <input type="text" class="form-control @error('category_name') is-invalid @enderror" id="category_name" name="category_name" value="{{$categories['category_name']}}">
                    @error('category_name')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="section_id">Select Section</label>
                    <select name="section_id" id="section_id" class="form-control @error('section_id') is-invalid @enderror">
                        <option value="">Select</option>
                        @foreach($sections as $section)
                            <option @selected($section['id']==$categories['section_id']) value="{{ $section['id'] }}">{{ $section['section_name']}}</option>
                        @endforeach
                    </select>
                    @error('section_id')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>

                  <div id="appendCategoriesLevel">
                    @include('admin.category.edit_append_categories_level')
                  </div>

                  <div class="form-group">
                    <label for="category_image">Category Image</label><br>
                    <input type="file" class="" id="category_image" name="category_image" value="{{url('uploads/image/category/'.$categories['category_image'])}}" >
                    @if(!empty($categories['category_image']))
                      <a target="_blank" href="{{url('uploads/image/category/'.$categories['category_image'])}}" class="link-secondary" style="display:inline;"> View Image</a>&nbsp;|&nbsp;
                      <a  href="{{route('delete-category-image',$categories['id'])}}" onclick="return confirm('Are you sure to delete Image?')" class="link-secondary" style="display:inline;"> Delete Image</a>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="category_discount">Category Discount</label>
                    <input type="text" class="form-control @error('category_discount') is-invalid @enderror" id="category_discount" name="category_discount" placeholder="Category Discount"  value="{{$categories['category_discount']}}">
                    @error('category_discount')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="description">Category Description</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{$categories['description']}}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>
                  
                  <div class="form-group">
                    <label for="url">Category URL</label>
                    <input type="text" class="form-control @error('url') is-invalid @enderror" id="url" name="url" placeholder="URL"  value="{{$categories['url']}}">
                    @error('url')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="meta_title">Meta Title</label>
                    <input type="text" class="form-control @error('meta_title') is-invalid @enderror" id="meta_title" name="meta_title" placeholder="Meta Title"  value="{{$categories['meta_title']}}">
                    @error('meta_title')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="meta_description">Meta Description</label>
                    <input type="text" class="form-control @error('meta_description') is-invalid @enderror" id="meta_description" name="meta_description" placeholder="Meta Description"  value="{{$categories['meta_description']}}">
                    @error('meta_description')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="meta_keywords">Meta Keywords</label>
                    <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" id="meta_keywords" name="meta_keywords" placeholder="Meta Keywords"  value="{{$categories['meta_keywords']}}">
                    @error('meta_keywords')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>

                </div>

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
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