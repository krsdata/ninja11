@extends('layouts.master') 
    @section('content') 


    <div class="app-container">
		<div class="main-header">
			<div class="container">
				<div class="row">
					<div class="col-sm-4 pro-pic">
						<img src="{{ url('assets/img/avtar.png') }}" alt="Ninjas11">
					</div>
					<div class="col-sm-4 text-center">
						<h4>Profile</h4>
					</div>
					<div class="col-sm-4">
						<a href="{{url('wallet')}}"><i class="fas fa-wallet"></i></a>
					</div>
				</div>
			</div>
			
		</div>
		
		<div class="content" style="padding-top:70px;">
			<div class="container login-page">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			
			<div class="card-body">
				<center><img id="imgFileUpload" alt="Select File" title="Select File" src="{{ url('assets/img/avtar-image.png') }}" height="100px;" style="cursor: pointer" /></center>
				<br />
				<span id="spnFilePath"></span>
				<input type="file" id="FileUpload1" style="display: none" />
				<script type="text/javascript">
				    window.onload = function () {
				        var fileupload = document.getElementById("FileUpload1");
				        var filePath = document.getElementById("spnFilePath");
				        var image = document.getElementById("imgFileUpload");
				        image.onclick = function () {
				            fileupload.click();
				        };
				        fileupload.onchange = function () {
				            var fileName = fileupload.value.split('\\')[fileupload.value.split('\\').length - 1];
				            filePath.innerHTML = "<b>Selected File: </b>" + fileName;
				        };
				    };
				</script>
				<form>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="text" class="form-control" value="vaibhav kasar">
						
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text">+91</span>
						</div>
						<input type="text" class="form-control" value="7000602982">
						
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-envelope"></i></span>
						</div>
						<input type="text" class="form-control" value="vaibhavdeveloper2014@gmail.com">
						
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="password" class="form-control" value="123456789">
					</div>
					
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-globe"></i></span>
						</div>
						<input type="text" class="form-control" value="Madhya Pradesh">
						
					</div>
					
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-globe"></i></span>
						</div>
						<input type="text" class="form-control" value="27 Oct 1992">
						
					</div>
					
					
					
					<div class="form-group" style="margin-top:15px">
						<input type="submit" value="Save Changes" class="btn float-right login_btn">
					</div>
				</form>
			</div>
			
		</div>
	</div>
</div>
@stop