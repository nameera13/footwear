@extends('front.layout.layouts')
@section('content')
<div id="page-content">
    	<!--Page Title-->
    <div class="page section-header text-center">
        <div class="page-title">
            <div class="wrapper"><h1 class="page-width">Register</h1></div>
        </div>
    </div>
        <!--End Page Title-->
        
    <div class="container" style="max-width:750px; margin-left:410px;">
        <div class="row">                
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 main-col offset-md-3">
                <div class="mb-4">
                    <form method="POST" action="{{ route('register') }}">
                    @csrf
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="firstname">First Name</label>
                                            <input type="text" name="firstname" placeholder="" id="firstname">
                                            <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname">Last Name</label>
                                            <input type="text" name="lastname" placeholder="" id="lastname">
                                            <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="mobile">Mobile</label>
                                    <input type="mobile" name="mobile"  id="mobile" :value="old('mobile')"  >
                                    <x-input-error :messages="$errors->get('mobile')" class="mt-2" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email"  id="email" :value="old('email')"  >
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" placeholder="" id="password"   autocomplete="new-password">   
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />                     	
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"  >  
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />                      	
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12">
                                <input type="submit" class="btn mb-3" value="Create">
                            </div>
                        </div>                        
                    </form>
                    <div class="row">
                        <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12">
                        <p class="mb-4">
                            <a href="{{route('login')}}" >Already Registered? </a>
                        </p>
                        </div>
                    </div>
                </div>
            </div>              
        </div>        
    </div>
</div>
@endsection
