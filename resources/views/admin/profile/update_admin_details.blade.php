@extends('admin.master')
@section('admin')
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h3>User Profile</h3>
        </div>
    </div>
    </div>
</section>

<section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Update Admin Details</h3>
            </div>


            <form action="{{url('admin/update-admin-details')}}" method="post" enctype="multipart/form-data">
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
                        <label for="email">Admin Username/Email</label>
                        <input type="text" id="email" class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly="">
                    </div> 
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ Auth::guard('admin')->user()->name }}">
                        @error('name')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image">Admin Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                        @if(!empty(Auth::guard('admin')->user()->image))
                            <a target="_blank" href="{{url('uploads/admin_image/'.Auth::guard('admin')->user()->image)}}" class="link-info">View Image</a>
                            <input type="hidden" name="current_admin_image" value="{{Auth::guard('admin')->user()->image}}">
                            &nbsp;|&nbsp;
                            <a  href="{{route('delete-admin-image',Auth::guard('admin')->user()->image)}}" onclick="return confirm('Are you sure to delete Image?')" class="link-info" style="display:inline;"> Delete Image</a>
                        @endif
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary">Cancel</button>
                </div>

            </form>

          </div>   
        </div>
      </div>

</section>
@endsection