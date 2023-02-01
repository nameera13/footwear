@extends('admin.master')
@section('admin')

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h2>Home Page Banner <a href="{{route('addbanner')}}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-plus-circle"></i> Add Banner</a></h2>

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><i class="bi bi-house" style="color:gray;"></i></a></li>
              <li class="breadcrumb-item active">Banners</li>
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
                <h3 class="card-title">Banner List</h3>
                <p class="text-right">Total Banners : {{\App\Models\Banner::count()}}</p>
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
                <table id="pagination" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>S.N.</th>
                    <th>Title</th>
                    <th>Photo</th>
                    <th>Type</th>
                    <th>link</th>
                    <th>alt</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($banners as $banner)
                  <tr>
                    <td> {{$loop->iteration}} </td>
                    <td> {{$banner['title']}} </td>
                    <td> <img src="{{url('uploads/image/banner/'.$banner['photo'])}}" style="height:80px;"> </td>
                    <td> {{$banner['type']}}</td>
                    <td> {{$banner['link']}} </td>
                    <td> {{$banner['alt']}} </td>
                    <td>    
                        @if($banner['status']==1)
                        <a class="updateBannerStatus" id="banner-{{$banner['id']}}" banner_id="{{$banner['id']}}"  href="javascript:void(0)">
                            <i style="font-size: 18px;  margin-left:15px;" class="fas fa-bookmark " status="active"></i>
                        </a>
                        @else
                        <a class="updateBannerStatus" id="banner-{{$banner['id']}}" banner_id="{{$banner['id']}}" href="javascript:void(0)" >
                            <i style="font-size: 18px;  margin-left:15px;" class="far fa-bookmark" status="inactive"></i>
                        </a>
                        @endif
                    </td> 
                    <td>
                        <a href="{{ route('editbanner',$banner['id']) }}"><i class="bi bi-pencil" style="color:gray;"></i></a> |
                        <a href="{{ route('deletebanner',$banner['id']) }}" onclick="return confirm('are you sure to delete?')"><i class="bi bi-trash" style="color: #cc0000;"></i></a>
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