@extends('admin.master')
@section('admin')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Section</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bi bi-house" style="color:gray;"></i></a></li>
              <li class="breadcrumb-item active">EditSection</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Section</h3>
              </div>
             
              <form action="{{ route('updatesection') }}" method="post">
                @csrf
                <input type="hidden" value="{{$sections['id']}}" name="sections_id">
                <div class="card-body">

                  <div class="form-group">
                    <label for="section_name">Section Name</label>
                    <input type="text" class="form-control @error('section_name') is-invalid @enderror" id="section_name" name="section_name" placeholder="Section Name" value="{{$sections['section_name']}}">
                    @error('section_name')
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

@endsection