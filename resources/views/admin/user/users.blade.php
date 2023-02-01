@extends('admin.master')
@section('admin')

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h2> Users </h2>

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><i class="bi bi-house" style="color:gray;"></i></a></li>
              <li class="breadcrumb-item active">Users</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    @if(Session::has('message'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong> {{ session::get('message') }} </strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">User List</h3>
                <p class="text-right">Total User : {{\App\Models\User::count()}}</p>
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
                <table id="pagination" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>S.N.</th>
                    <th>FirstName</th>
                    <th>LastName</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Country</th>
                    <th>Pincode</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Status</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($users as $user)                
                    <tr>
                        <td> {{$loop->iteration}} </td>
                        <td> {{$user['firstname']}} </td>
                        <td> {{$user['lastname']}} </td>
                        <td> {{$user['address']}} </td>
                        <td> {{$user['city']}} </td>
                        <td> {{$user['state']}} </td>
                        <td> {{$user['country']}} </td>
                        <td> {{$user['pincode']}} </td>
                        <td> {{$user['mobile']}} </td>
                        <td> {{$user['email']}} </td>
                        <td>    
                            @if($user['status']==1)
                            <a class="updateUserStatus" id="user-{{$user['id']}}" user_id="{{$user['id']}}"  href="javascript:void(0)">
                                <i style="font-size: 18px;  margin-left:15px;" class="fas fa-bookmark " status="active"></i>
                            </a>
                            @else
                            <a class="updateUserStatus" id="user-{{$user['id']}}" user_id="{{$user['id']}}" href="javascript:void(0)" >
                                <i style="font-size: 18px;  margin-left:15px;" class="far fa-bookmark" status="inactive"></i>
                            </a>
                            @endif
                        </td> 
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div> 
            </div>  
          </div>  
        </div> 
      </div>

    </section>
    
@endsection