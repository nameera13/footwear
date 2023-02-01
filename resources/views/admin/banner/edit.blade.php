@extends('admin.master')
@section('admin')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Home Page Banner</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bi bi-house" style="color:gray;"></i></a></li>
              <li class="breadcrumb-item active">Edit Banner Image</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    @if(Session::has('message'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong> {{ session::get('message') }} </strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Banner Image</h3>
              </div>
             
              <form action="{{ route('updatebanner') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="{{$banners['id']}}" name="banner_id">
                <div class="card-body">

                  <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Title" value="{{$banners['title']}}">
                    @error('title')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="photo">Photo</label><br>
                    <input type="file" class="@error('photo') is-invalid @enderror"  name="photo" id="photo" value="{{url('uploads/image/banner/'.$banners['photo'])}}">
                    @if(!empty($banners['photo']))
                      <a target="_blank" href="{{url('uploads/image/banner/'.$banners['photo'])}}" class="link-secondary" style="display:inline;"> View Image</a>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="type">Banner Type</label><br>
                    <select class="form-control" name="type" id="type" required="">
                      <option value="">Select</option>
                      <option @selected($banners['type'] && $banners['type']=="Slider")  value="Slider">Slider</option>
                      <option @selected($banners['type'] && $banners['type']=="Fix") >Fix</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                      <label for="link">Banner Link</label>
                      <input type="text" class="form-control @error('link') is-invalid @enderror" id="link" name="link" placeholder="Link" value="{{$banners['link']}}">
                      @error('link')
                          <div class="invalid-feedback">{{$message}}</div>
                      @enderror
                  </div>

                  <div class="form-group">
                      <label for="alt">Banner Alternate Text</label>
                      <input type="text" class="form-control @error('alt') is-invalid @enderror" id="alt" name="alt" placeholder="Alternate Text" value="{{$banners['alt']}}">
                      @error('alt')
                          <div class="invalid-feedback">{{$message}}</div>
                      @enderror
                  </div>

                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
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