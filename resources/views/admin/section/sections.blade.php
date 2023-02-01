@extends('admin.master')
@section('admin')

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h2>Sections <a href="{{route('addsection')}}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-plus-circle"></i> Create Section</a></h2>

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><i class="bi bi-house" style="color:gray;"></i></a></li>
              <li class="breadcrumb-item active">Sections</li>
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
                <h3 class="card-title">Section List</h3>
                <p class="text-right">Total Section : {{\App\Models\Section::count()}}</p>
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
                <table id="pagination" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>S.N.</th>
                    <th>Section Name</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($sections as $section)
                  <tr>
                    <td> {{$loop->iteration}} </td>
                    <td> {{$section['section_name']}} </td>
                    <td>    
                        @if($section['status']==1)
                        <a class="updateSectionStatus" id="section-{{$section['id']}}" section_id="{{$section['id']}}"  href="javascript:void(0)">
                            <i style="font-size: 18px;  margin-left:15px;" class="fas fa-bookmark " status="active"></i>
                        </a>
                        @else
                        <a class="updateSectionStatus" id="section-{{$section['id']}}" section_id="{{$section['id']}}" href="javascript:void(0)" >
                            <i style="font-size: 18px;  margin-left:15px;" class="far fa-bookmark" status="inactive"></i>
                        </a>
                        @endif
                    </td> 
                    <td>
                        <a href="{{route('editsection',$section['id'])}}"><i class="fa fa-pencil-square-o" style="font-size: 20px; color:gray;"></i></a> |  
                        <a href="{{route('deletesection',$section['id'])}}" onclick="return confirm('Are you sure to delete Section?')"><i class="fas fa-trash" style="font-size: 20px; color:#D2042D;"></i></a> 
                  
                        <!-- <a href="javascript:void(0)" class="confirmDelete" module="section" moduleid="{{$loop->iteration}}"><i class="fas fa-trash" style="font-size: 20px; color:#D2042D;"></i></a>  -->
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