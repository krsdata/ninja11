@extends('layouts.master') 
    @section('content') 


    <div class="app-container">
		<div class="main-header">
			<div class="container">
				<div class="row">
					<div class="col-sm-4 pro-pic">
						<img src="img/avtar.png" alt="Ninjas11">
					</div>
					<div class="col-sm-4 text-center">
						<h4>Ninjas11
							@foreach($user as $key => $result)

    name : {{$result->name}}
    @endforeach
						</h4>
					</div>
					<div class="col-sm-4">
						<i class="fas fa-wallet"></i>
					</div>
				</div>
			</div>
			
		</div>
		
		<div class="content" style="padding-top:70px;">
			<div class="container">
				<div class="row" style="margin-bottom:10px;">
					<div class="col-sm-12 text-center">
						<img src="img/slide3.png" alt="">
					</div>
				</div>
				
				
				<div class="row">
					<div class="col-sm-12">
						<div class="matches-container">
							<div class="full-match-card-container">
								<a class="match-card-content-container" href="contest.html">
									<div class="match-card-header">PUN vs BAN</div>
									<div class="match-card-primary-container">
									<div class="squad-container">
									<div class="squad-color-ribbon" style="background-color: rgb(196, 96, 100);"></div>
									<img class="squad-logo" src="{{ url('assets/img/PUN.png')}}" alt="Punjab">
									<div class="squad-info">
									<div class="squad-name reaction-placeholder">PUN</div>
									</div>
									</div>
									<div class="not-started-time">
									<div>11 AM</div><div>Mon, 13 Apr</div>
									</div>
									<div class="squad-container away">
									<div class="squad-color-ribbon" style="background-color: rgb(189, 81, 99);"></div>
									<img class="squad-logo" src="img/BAN.png" alt="Bangalore">
									<div class="squad-info">
									<div class="squad-name reaction-placeholder">BAN</div>
									</div></div></div>
									<div class="match-card-footer">Match Starts in 12 hours</div>
								</a>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-12">
						<div class="matches-container">
							<div class="full-match-card-container">
								<a class="match-card-content-container" href="contest.html">
									<div class="match-card-header">MUM vs CHE</div>
									<div class="match-card-primary-container">
									<div class="squad-container">
									<div class="squad-color-ribbon" style="background-color: rgb(67, 100, 140);"></div>
									<img class="squad-logo" src="img/MUM.png" alt="Mumbai">
									<div class="squad-info">
									<div class="squad-name reaction-placeholder">MUM</div>
									</div>
									</div>
									<div class="not-started-time">
									<div>11 AM</div><div>Mon, 13 Apr</div>
									</div>
									<div class="squad-container away">
									<div class="squad-color-ribbon" style="background-color: rgb(116, 80, 112);"></div>
									<img class="squad-logo" src="img/CHE.png" alt="Chennai">
									<div class="squad-info">
									<div class="squad-name reaction-placeholder">CHE</div>
									</div></div></div>
									<div class="match-card-footer">Match Starts in 12 hours</div>
								</a>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-12">
						<div class="matches-container">
							<div class="full-match-card-container">
								<a class="match-card-content-container" href="contest.html">
									<div class="match-card-header">PUN vs BAN</div>
									<div class="match-card-primary-container">
									<div class="squad-container">
									<div class="squad-color-ribbon" style="background-color: rgb(196, 96, 100);"></div>
									<img class="squad-logo" src="img/PUN.png" alt="Punjab">
									<div class="squad-info">
									<div class="squad-name reaction-placeholder">PUN</div>
									</div>
									</div>
									<div class="not-started-time">
									<div>11 AM</div><div>Mon, 13 Apr</div>
									</div>
									<div class="squad-container away">
									<div class="squad-color-ribbon" style="background-color: rgb(189, 81, 99);"></div>
									<img class="squad-logo" src="img/BAN.png" alt="Bangalore">
									<div class="squad-info">
									<div class="squad-name reaction-placeholder">BAN</div>
									</div></div></div>
									<div class="match-card-footer">Match Starts in 12 hours</div>
								</a>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-12">
						<div class="matches-container">
							<div class="full-match-card-container">
								<a class="match-card-content-container" href="contest.html">
									<div class="match-card-header">PUN vs BAN</div>
									<div class="match-card-primary-container">
									<div class="squad-container">
									<div class="squad-color-ribbon" style="background-color: rgb(196, 96, 100);"></div>
									<img class="squad-logo" src="img/PUN.png" alt="Punjab">
									<div class="squad-info">
									<div class="squad-name reaction-placeholder">PUN</div>
									</div>
									</div>
									<div class="not-started-time">
									<div>11 AM</div><div>Mon, 13 Apr</div>
									</div>
									<div class="squad-container away">
									<div class="squad-color-ribbon" style="background-color: rgb(189, 81, 99);"></div>
									<img class="squad-logo" src="img/BAN.png" alt="Bangalore">
									<div class="squad-info">
									<div class="squad-name reaction-placeholder">BAN</div>
									</div></div></div>
									<div class="match-card-footer">Match Starts in 12 hours</div>
								</a>
							</div>
						</div>
					</div>
				</div>
				
			</div>
			
		</div>
@stop