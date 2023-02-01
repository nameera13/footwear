@extends('front.layout.layouts')
@section('content')
<div id="page-content" >
    	<!--Page Title-->
    	<div class="page section-header text-center">
			<div class="page-title">
        		<div class="wrapper"><h1 class="page-width">Login</h1></div>
      		</div>
		</div>
        <!--End Page Title-->
        <div style="max-width:360px; margin-left:570px;">
            @if(Session::has('message'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong> <?php echo session::get('message');?> </strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(Session::has('error_message'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong> <?php echo session::get('error_message'); ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        </div>
        <div class="container" style="max-width:750px; margin-left:380px;">            
        	<div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 main-col offset-md-3">
                        <div class="mb-4">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" placeholder="" id="email" :value="old('email')"  autofocus >
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" name="password" placeholder="" id="password"   autocomplete="current-password"> 
                                            <x-input-error :messages="$errors->get('password')" class="mt-2" />                       	
                                        </div>
                                    </div>
                                    </div>
                                    <div class="row">
                                    <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12">
                                        <input type="submit" class="btn mb-3" value="Sign In">    
                                    </div>
                                </div>                        
                            </form>
       
                            <div class="row">
                                <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12">
                                <p class="mb-4">
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" id="RecoverPassword">Forgot your password?</a> &nbsp; | &nbsp;
                                        <a href="{{ route('register') }}" id="customer_register_link">Create account</a>
                                    @endif
                                </p>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>        
</div>

@endsection