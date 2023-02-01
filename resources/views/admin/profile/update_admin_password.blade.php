@extends('admin.master')
@section('admin')
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h3>Change Password</h3>
        </div>
    </div>
    </div>
</section>

<section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Update Admin Password</h3>
            </div>


            <form action="{{url('admin/update-admin-password')}}" method="post" >
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
                        <input type="text" id="email" class="form-control" value="{{$adminDetails['email']}}" readonly="">
                    </div> 
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" class="form-control" name="current_password" placeholder="Enter Current Password" required="">
                        <span id="check_password"></span>
                    </div>
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" class="form-control" name="new_password" placeholder="Enter New Password" required="">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" class="form-control" name="confirm_password" placeholder="Enter Confirm Password" required="">
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