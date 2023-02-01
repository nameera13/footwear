@extends('admin.master')
@section('admin')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Filter Values</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bi bi-house" style="color:gray;"></i></a></li>
              <li class="breadcrumb-item active">Filter Values</li>
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
             
              <form  @if(empty($filter['id'])) action="{{url('admin/add-edit-filter-value')}}" @else action="{{ url('admin/add-edit-filter-value/'.$filter['id'])}}" @endif method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    @if(Session::has('message'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <strong> {{ session::get('message') }} </strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif                  
                  
                  <div class="form-group">
                    <label for="filter_id">Select Filter</label>
                    <select name="filter_id" id="filter_id" class="form-control @error('filter_id') is-invalid @enderror" >
                        <option value="">Select</option>
                            @foreach($filters as $filter)
                                <option value="{{$filter['id']}}">{{$filter['filter_name']}}</option>
                            @endforeach
                    </select>
                    @error('filter_id')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>
                  
                  <div class="form-group">
                    <label for="filter_value">Filter Value</label>
                    <input type="text" class="form-control @error('filter_value') is-invalid @enderror" id="filter_value" name="filter_value" placeholder="Filter Value" @if(!empty($filter['filter_value'])) value="{{ $filter['filter_value']}}" @else :value="{{old('filter_value')}}" @endif>
                    @error('filter_value')
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