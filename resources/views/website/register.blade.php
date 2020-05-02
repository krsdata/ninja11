@extends('layouts.master') 
    @section('content') 


    <div class="app-container">
		<div class="main-header">
			<div class="container">
				<div class="row">
					<div class="col-sm-4 pro-pic">
						<!-- <img src="img/avtar.png" alt="Ninjas11"> -->
					</div>
					<div class="col-sm-4 text-center">
						<h4>Ninjas11</h4>
					</div>
					<div class="col-sm-4">
						<i class="fas fa-wallet"></i>
					</div>
				</div>
			</div>
			
		</div>
		
		<div class="content" style="padding-top:70px;">
			<div class="container login-page">
		<div class="d-flex justify-content-center h-100">
			<div class="card">
				<div class="card-header">
					<h3>Register</h3>
					@if ($errors->any())
					    <div class="alert alert-danger">
					        <ul>
					            @foreach ($errors->all() as $error)
					                <li>{{ $error }}</li>
					            @endforeach
					        </ul>
					    </div>
					@endif
					@if(isset($message))
						<div class="alert alert-success">{{$message}} </div>
					@endif
				</div>
				<div class="card-body">
					{!! Form::model($user, ['route' => ['signup'],'class'=>'form-horizontal user-form','id'=>'user-form','enctype'=>'multipart/form-data']) !!} 
                                 
						<div class="input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="fas fa-user"></i></span>
							</div>
							<input type="text" name="name" class="form-control" placeholder="Name" value="{{old('name')}}">
						</div>
						<div class="input-group form-group {{ $errors->first('mobile_number', ' has-error') }}">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="fas fa-phone"></i></span>
							</div>
							<!-- <span class="help-block">{{ $errors->first('mobile_number', ':message') }}</span> -->
							<input type="text" name="mobile_number" class="error form-control" placeholder="Mobile Number 10 Digit" value="{{old('mobile_number')}}"> 
                
						</div>
						<div class="input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="fas fa-envelope"></i></span>
							</div>
							<input type="email" name="email" class="form-control" placeholder="Email" value="{{old('email')}}">
							
						</div>
						<div class="input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input type="password" name="password" class="form-control" placeholder="password" value="{{old('password')}}">
						</div>
						<div class="input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" value="{{old('password_confirmation')}}">
						</div>
						<div class="input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="fas fa-user"></i></span>
							</div>
							<input type="text" name="refferal_code" class="form-control" placeholder="Referral Code">
							
						</div>
						<div class="row align-items-center remember">
							 By click register, You agree terms and condition!
						</div>
						<div class="form-group" style="margin-top:15px">
							<input type="submit" value="Register" class="btn float-right login_btn">
						</div>
					 {!! Form::close() !!}  
				</div>
				<div class="card-footer">
					<div class="d-flex justify-content-center links">
						Already have an account?<a href="{{url('signin')}}">Login</a>
					</div>
					<div class="d-flex justify-content-center">
						<a href="#">Forgot your password?</a>
					</div>
				</div>
			</div>
		</div>
		</div>
				
		</div>
		
	</div>
@stop