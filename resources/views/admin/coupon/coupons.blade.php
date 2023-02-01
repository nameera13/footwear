@extends('admin.master')
@section('admin')

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h2> Coupon <a href="{{ url('admin/add-edit-coupon')}}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-plus-circle"></i> Add Coupon</a></h2>

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><i class="bi bi-house" style="color:gray;"></i></a></li>
              <li class="breadcrumb-item active">coupons</li>
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
                <h3 class="card-title">Coupon List</h3>
                <p class="text-right">Total Coupons : {{\App\Models\Coupon::count()}}</p>
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
                <table id="pagination" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>S.N.</th>
                    <th>Coupon Code</th>
                    <th>Coupon Type</th>
                    <th>Amount</th>
                    <th>Expiry Date</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($coupons as $coupon)
                  <tr>
                    <td> {{$loop->iteration}} </td>
                    <td> {{$coupon['coupon_code']}} </td>
                    <td> {{$coupon['coupon_type']}}</td>
                    <td>
                        {{$coupon['amount']}}  
                        @if($coupon['amount_type']=="Percentage")
                          %
                        @else
                          INR
                        @endif                      
                    </td>
                    <td> {{$coupon['expiry_date']}} </td>
                    <td>    
                        @if($coupon['status']==1)
                        <a class="updateCouponStatus" id="coupon-{{$coupon['id']}}" coupon_id="{{$coupon['id']}}"  href="javascript:void(0)">
                            <i style="font-size: 18px;  margin-left:15px;" class="fas fa-bookmark " status="active"></i>
                        </a>
                        @else
                        <a class="updateCouponStatus" id="coupon-{{$coupon['id']}}" coupon_id="{{$coupon['id']}}" href="javascript:void(0)" >
                            <i style="font-size: 18px;  margin-left:15px;" class="far fa-bookmark" status="inactive"></i>
                        </a>
                        @endif
                    </td> 
                    <td>
                        <a href="{{ url('admin/add-edit-coupon/'.$coupon['id']) }}"><i class="bi bi-pencil" style="color:gray;"></i></a> |
                        <a href="{{ route('deletecoupon',$coupon['id']) }}" onclick="return confirm('are you sure to delete?')"><i class="bi bi-trash" style="color: #cc0000;"></i></a>
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