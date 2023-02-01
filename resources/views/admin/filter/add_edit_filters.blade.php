@extends('admin.master')
@section('admin')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Filters</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bi bi-house" style="color:gray;"></i></a></li>
              <li class="breadcrumb-item active">Filters</li>
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
                <h3 class="card-title">{{ $title }}</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
             
              <form  @if(empty($filter['id'])) action="{{url('admin/add-edit-filter')}}" @else action="{{ url('admin/add-edit-filter/'.$filter['id'])}}" @endif method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    @if(Session::has('message'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <strong> {{ session::get('message') }} </strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif                  
                  
                  <div class="form-group">
                    <label for="cat_ids">Select Category</label>
                    <select name="cat_ids[]" id="cat_ids" class="form-control @error('cat_ids') is-invalid @enderror" multiple="" style="height: 200px;">
                        <option value="">Select</option>
                        @foreach($categories as $section)
                            <optgroup label="{{ $section['section_name']}}" style="color:#313131"></optgroup>
                            @foreach($section['categories'] as $category)
                                <option @if(!empty($filter['category_id']==$category['id'])) selected="" @endif value="{{$category['id']}}">&nbsp;&nbsp;&nbsp;&raquo;&nbsp;{{$category['category_name']}}</option>
                                @foreach($category['subcategories'] as $subcategory)
                                    <option @if(!empty($filter['category_id']==$subcategory['id'])) selected="" @endif value="{{$subcategory['id']}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&raquo;&nbsp;{{$subcategory['category_name']}}</option>
                                @endforeach
                            @endforeach
                        @endforeach
                    </select>
                    @error('cat_ids')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>
                  
                  <div class="form-group">
                    <label for="filter_name">Filter Name</label>
                    <input type="text" class="form-control @error('filter_name') is-invalid @enderror" id="filter_name" name="filter_name" placeholder="Filter Name" @if(!empty($filter['filter_name'])) value="{{ $filter['filter_name']}}" @else :value="{{old('filter_name')}}" @endif>
                    @error('filter_name')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="filter_column">Filter Column</label>
                    <input type="text" class="form-control @error('filter_column') is-invalid @enderror" id="filter_column" name="filter_column" placeholder="Filter Column" @if(!empty($filter['filter_column'])) value="{{ $filter['filter_column']}}" @else :value="{{old('filter_column')}}" @endif>
                    @error('filter_column')
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