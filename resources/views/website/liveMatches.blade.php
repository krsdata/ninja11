@extends('layouts.master') 
    @section('content') 


    <div class="app-container">
		
		 @include('partial.navigation')
		
		<div class="content" style="padding-top:54px;">
			
			<div class="container">
				<div class="joined-head">
					<div class="row">
						<div class="col-sm-4 text-center">
							<a href="{{url('joinedMatches')}}">Upcoming</a>
						</div>
						<div class="col-sm-4 text-center">
							<a href="{{url('liveMatches')}}" class="active">Live</a>
						</div>
						<div class="col-sm-4 text-center">
							<a href="{{url('resultMatches')}}">Result</a>
						</div>
					</div>
				</div>
			</div>
			<div class="container">
				
				
				<div class="row">
					<div class="col-sm-12">
						<div class="matches-container">
							<div class="full-match-card-container">
								<a class="match-card-content-container" href="#">
									<div class="match-card-header joined-contest-text">Joined 3 Contest</div>
									<div class="match-card-primary-container">
									<div class="squad-container">
									<div class="squad-color-ribbon" style="background-color: rgb(196, 96, 100);"></div>
									<img class="squad-logo" src="{{ url('assets/img/PUN.png') }}" alt="Punjab">
									<div class="squad-info">
									<div class="squad-name reaction-placeholder">PUN</div>
									</div>
									</div>
									<div class="not-started-time">
									
									</div>
									<div class="squad-container away">
									<div class="squad-color-ribbon" style="background-color: rgb(189, 81, 99);"></div>
									<img class="squad-logo" src="{{ url('assets/img/BAN.png') }}" alt="Bangalore">
									<div class="squad-info">
									<div class="squad-name reaction-placeholder">BAN</div>
									</div></div></div>
									
								</a>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-12">
						<div class="matches-container">
							<div class="full-match-card-container">
								<a class="match-card-content-container" href="#">
									<div class="match-card-header joined-contest-text">Joined 5 Contest</div>
									<div class="match-card-primary-container">
									<div class="squad-container">
									<div class="squad-color-ribbon" style="background-color: rgb(67, 100, 140);"></div>
									<img class="squad-logo" src="{{ url('assets/img/MUM.png') }}" alt="Mumbai">
									<div class="squad-info">
									<div class="squad-name reaction-placeholder">MUM</div>
									</div>
									</div>
									<div class="not-started-time">
									
									</div>
									<div class="squad-container away">
									<div class="squad-color-ribbon" style="background-color: rgb(116, 80, 112);"></div>
									<img class="squad-logo" src="{{ url('assets/img/CHE.png') }}" alt="Chennai">
									<div class="squad-info">
									<div class="squad-name reaction-placeholder">CHE</div>
									</div></div></div>
									<div class="match-card-footer">Not Started Yet</div>
								</a>
							</div>
						</div>
					</div>
				</div>
				
				
			</div>
			
		</div>
@stop