@extends('admin.master')
@section('admin')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $title }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bi bi-house" style="color:gray;"></i></a></li>
              <li class="breadcrumb-item active">Coupon</li>
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
                <h3 class="card-title">Coupon</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
             
              <form  @if(empty($coupon['id'])) action="{{url('admin/add-edit-coupon')}}" @else action="{{ url('admin/add-edit-coupon/'.$coupon['id'])}}" @endif method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    @if(Session::has('message'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong> {{ session::get('message') }} </strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                  @if(empty($coupon['coupon_code']))
                  <div class="form-group">
                    <label for="coupon_option">Coupon Option</label><br>
                    <input type="radio" name="coupon_option" id="AutomaticCoupon" value="Automatic" checked="">&nbsp;Automatic&nbsp;&nbsp;
                    <input type="radio" name="coupon_option" id="ManualCoupon" value="Manual" checked="">&nbsp;Manual&nbsp;&nbsp;
                    @error('coupon_option')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group" id="couponField">
                    <label for="coupon_code">Coupon Code</label>
                    <input type="text" class="form-control @error('coupon_code') is-invalid @enderror" id="coupon_code" name="coupon_code" placeholder="Coupon Code" >
                    @error('coupon_code')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>
                  @else
                    <input type="hidden" name="coupon_option" value="{{ $coupon['coupon_option'] }}">
                    <input type="hidden" name="coupon_code" value="{{ $coupon['coupon_code']}}">
                    <div class="form-group">
                      <label for="coupon_code">Coupon Code:</label>
                      <span>{{ $coupon['coupon_code'] }}</span>
                    </div>
                  @endif
                  <div class="form-group">
                    <label for="coupon_type">Coupon Type</label><br>
                    <input type="radio" name="coupon_type" value="MultipleTimes" @if(isset($coupon['coupon_type']) && $coupon['coupon_type']=="MultipleTimes") checked="" @endif>&nbsp;Multiple Times&nbsp;&nbsp;
                    <input type="radio" name="coupon_type" value="SingleTime"   @if(isset($coupon['coupon_type']) && $coupon['coupon_type']=="SingleTime") checked="" @endif>&nbsp;Single Time&nbsp;&nbsp;
                    @error('coupon_type')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="amount_type">Amount Type</label><br>
                    <input type="radio" name="amount_type" value="Percentage"  @if(isset($coupon['amount_type']) && $coupon['amount_type']=="Percentage") checked="" @endif>&nbsp;Percentage&nbsp;(in %)&nbsp;
                    <input type="radio" name="amount_type" value="Fixed"  @if(isset($coupon['amount_type']) && $coupon['amount_type']=="Fixed") checked="" @endif>&nbsp;Fixed&nbsp;(in INR or USD)
                    @error('amount_type')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="text" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" placeholder="Amount" @if(!empty($coupon['amount'])) value="{{ $coupon['amount']}}" @else :value="{{old('amount')}}" @endif>
                    @error('amount')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="categories">Select Category</label>
                    <select name="categories[]" class="form-control @error('categories') is-invalid @enderror" multiple="">
                        <option value="">Select</option>
                        @foreach($categories as $section)
                            <optgroup label="{{ $section['section_name']}}" style="color:#313131"></optgroup>
                            @foreach($section['categories'] as $category)
                                <option value="{{ $category['id'] }}" @if(in_array($category['id'],$selCats)) selected="" @endif>&nbsp;&nbsp;&nbsp;&raquo;&nbsp;{{$category['category_name']}}</option>
                                @foreach($category['subcategories'] as $subcategory)
                                    <option value="{{ $subcategory['id'] }}" @if(in_array($subcategory['id'],$selCats)) selected="" @endif>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&raquo;&nbsp;{{$subcategory['category_name']}}</option>
                                @endforeach
                            @endforeach
                        @endforeach
                    </select>
                    @error('categories')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="users">Select User</label>
                    <select name="users[]" class="form-control @error('users') is-invalid @enderror" multiple="">
                        @foreach($users as $user)
                          <option value="{{ $user['email'] }}" @if(in_array($user['email'],$selUsers)) selected="" @endif>{{ $user['email'] }}</option>
                        @endforeach
                    </select>
                  </div>                  
                  <div class="form-group">
                    <label for="expiry_date">Expiry Date</label>
                    <input type="date" class="form-control @error('expiry_date') is-invalid @enderror" id="expiry_date" name="expiry_date" placeholder="Expiry Date" @if(!empty($coupon['expiry_date'])) value="{{ $coupon['expiry_date']}}" @else :value="{{old('expiry_date')}}" @endif>                           
                    @error('expiry_date')
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