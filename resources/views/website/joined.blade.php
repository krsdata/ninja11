@extends('layouts.master') 
    @section('content') 


    <div class="app-container">
		<div class="main-header">
			<div class="container">
				<div class="row">
					<div class="col-sm-4 pro-pic">
						<a href="{{url('joinedMatches')}}"><i class="fas fa-chevron-left"></i></a>
					</div>
					<div class="col-sm-4 text-center">
						<h4>Ninjas11</h4>
					</div>
					<div class="col-sm-4">
						<a href="{{url('wallet')}}"><i class="fas fa-wallet"></i></a>
					</div>
				</div>
			</div>
			
		</div>
		
		
		
		<div class="content" style="padding-top:54px;">
			<div class="info-bar js-match-header__info-bar infobar_0dc07">
				<div class="infobarContent_628aa">
					<div class="infobarContentRow_7ae93">
						<div class="js--match-header-title infobarContentLeft_04a34"><img src="{{ url('assets/img/banglore.png') }}"></div>
							<div class="infobarContentCenter_5f791">
								<div class="timer_1aa54"><span class="timeRemaining_96d65">
								<div class="timer_44feb">02h 43m 51s</div></span></div>
							</div>
						<div class="js--guru-link infobarContentRight_ac9bd"><img src="{{ url('assets/img/mumbai.png') }}"></div>
					</div>
				</div>
			</div>
			
			<div class="container">
				
				
				<div class="row">
					<div class="col-sm-12">
					<a class="js--contest-card contestCardWrapper_fbec5 containerShadow_c2514" href="#"><div><div><div class="contestSpecMoneyInfo_20124"><div class="contestSpecRow_01429"><div class="contestCardLabel_7ca40">Grand League</div></div><div class="contestSpecRow_01429"><div class="js--contest-card__prize-pool prizePool_565d2"><i class="fas fa-rupee-sign"></i> 10 Lakhs</div></div></div>
					<div class="progress-container">
										<div class="progress">
					  	<div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
						</div>
					</div>
					</div>
					<div class="spotsContainer_9c427"><div class="contestSpecRow_01429"><div class="spotLefts_8d583 contestFilling_14509">9,587 spots left</div><div class="totalSpots_b62ba">50,000 spots</div></div></div></div><div class="contestSpec_a3ebb"><div class="iconLabelGroup_f55e1"><div class="iconLabelWrapper_43690"><span><i class="fa fa-trophy" style="color:#f58a14;"></i> 50% Winners</span></div></div><div class="iconLabelGroup_f55e1" style="justify-content: flex-end;"><div class="squareWithTwoRoundCorner_1291a confirm-league">C</div><div style="padding-left: 12px;"><div class="squareWithTwoRoundCorner_1291a multi-join">M</div></div></div></div></div></a>
					</div>
				</div>
				
				
				
				
				
				<div class="row">
					<div class="col-sm-12">
					<a class="js--contest-card contestCardWrapper_fbec5 containerShadow_c2514" href="#"><div><div><div class="contestSpecMoneyInfo_20124"><div class="contestSpecRow_01429"><div class="contestCardLabel_7ca40">Single Star</div></div><div class="contestSpecRow_01429"><div class="js--contest-card__prize-pool prizePool_565d2"><i class="fas fa-rupee-sign"></i> 2000</div><div><div style="display: flex; align-items: center;"></div></div></div></div>
					<div class="progress-container">
										<div class="progress">
					  	<div class="progress-bar" role="progressbar" style="width: 70%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
						</div>
					</div>
					</div>
					<div class="spotsContainer_9c427"><div class="contestSpecRow_01429"><div class="spotLefts_8d583 contestFilling_14509">2 spots left</div><div class="totalSpots_b62ba">3 spots</div></div></div></div><div class="contestSpec_a3ebb"><div class="iconLabelGroup_f55e1"><div class="iconLabelWrapper_43690"><span><i class="fa fa-trophy" style="color:#f58a14;"></i> 50% Winners</span></div></div><div class="iconLabelGroup_f55e1" style="justify-content: flex-end;"><div class="squareWithTwoRoundCorner_1291a confirm-league">C</div><div style="padding-left: 12px;"><div class="squareWithTwoRoundCorner_1291a multi-join">M</div></div></div></div></div></a>
					</div>
				</div>
				
			</div>
			
		</div>
@stop