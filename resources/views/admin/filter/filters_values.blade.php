<?php use App\Models\ProductsFilter; ?>
@extends('admin.master')
@section('admin')

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h2>Filter Values <br>
              <a href="{{url('admin/add-edit-filter-value')}}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-plus-circle"></i> Add Filter Values</a>
              <a href="{{route('filters')}}" class="btn btn-sm btn-secondary"><i class="bi bi-plus-circle"></i> View Filters </a></h2>

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><i class="bi bi-house" style="color:gray;"></i></a></li>
              <li class="breadcrumb-item active">Filters</li>
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
                <h3 class="card-title">Filter Value List</h3>
                <p class="text-right">Total Filters Value: {{\App\Models\ProductsFilterValue::count()}}</p>
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
                <table id="pagination" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>S.N.</th>
                    <th>Filter Id</th>
                    <th>Filter Name</th>
                    <th>Filter Value</th>                    
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($filters_values as $filter)
                  <tr>
                    <td> {{$loop->iteration}} </td>
                    <td> {{$filter['filter_id']}} </td>
                    <td> 
                      <?php
                        echo $getFilterName = ProductsFilter::getFilterName($filter['filter_id']);
                      ?>
                    </td>
                    <td> {{$filter['filter_value']}}</td>                                     
                    <td>    
                        @if($filter['status']==1)
                        <a class="updateFilterValueStatus" id="filter-{{$filter['id']}}" filter_id="{{$filter['id']}}"  href="javascript:void(0)">
                            <i style="font-size: 18px;  margin-left:15px;" class="fas fa-bookmark " status="active"></i>
                        </a>
                        @else
                        <a class="updateFilterValueStatus" id="filter-{{$filter['id']}}" filter_id="{{$filter['id']}}" href="javascript:void(0)" >
                            <i style="font-size: 18px;  margin-left:15px;" class="far fa-bookmark" status="inactive"></i>
                        </a>
                        @endif
                    </td> 
                    <td>
                        <a href="{{ url('admin/add-edit-filter-value/'.$filter['id']) }}"><i class="bi bi-pencil" style="color:gray;"></i></a> |
                        <a href="{{ route('deletefilter',$filter['id']) }}" onclick="return confirm('are you sure to delete?')"><i class="bi bi-trash" style="color: #cc0000;"></i></a>
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