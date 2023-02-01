@extends('admin.master')
@section('admin')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Section</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bi bi-house" style="color:gray;"></i></a></li>
              <li class="breadcrumb-item active">Section</li>
              <li class="breadcrumb-item active">AddSection</li>
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
                <h3 class="card-title">Section</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
             
              <form action="{{route('storesection')}}" method="post" >
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="section_name">Section Name</label>
                    <input type="text" class="form-control @error('section_name') is-invalid @enderror" id="section_name" name="section_name" placeholder="Section Name" :value="{{old('section_name')}}">
                    @error('section_name')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>

                  <!-- <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                  </div> -->
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