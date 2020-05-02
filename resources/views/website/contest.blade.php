@extends('layouts.master') 
    @section('content') 
    <div class="app-container">
		 @include('partial.navigation')
		
		
		<div class="content" style="padding-top:54px;">
			<div class="info-bar js-match-header__info-bar infobar_0dc07" style="padding: 0px;margin: 15px;">
				<div class="infobarContent_628aa">
					<div class="infobarContentRow_7ae93">
						<div class="js--match-header-title infobarContentLeft_04a34"><img src="{{ url('assets/img/banglore.png') }}"></div>
							<div class="infobarContentCenter_5f791">
								<div class="timer_1aa54"><span class="timeRemaining_96d65">
								<div class="timer_44feb" > 
									<span id="contest_time">
										<script type="text/javascript">
											getTimer('contest_time', "{{$start_time}}");
										</script>
									 </span>

								</div></span></div>
							</div>
						<div class="js--guru-link infobarContentRight_ac9bd"><img src="{{ url('assets/img/mumbai.png') }}"></div>
					</div>
				</div>
			</div>
			<div class="container">
				@foreach($contest as $key => $result)
				<div class="row">
					<div class="col-sm-12">
						<div class="match-list-header">
							<div class="match-count-caption">{{$result->contestTitle}}</div>
							<div class="headerText_d7966">{{$result->contestSubTitle}}</div>
							<div class="trophy-right">
								<i class="fa fa-trophy"></i>
							</div>
						</div>
					</div>
				</div>
				@foreach($result->contests as $key => $result)
				<div class="row">
					<div class="col-sm-12">
					<a class="js--contest-card contestCardWrapper_fbec5 containerShadow_c2514" href="#"><div><div><div class="contestSpecMoneyInfo_20124"><div class="contestSpecRow_01429"><div class="contestCardLabel_7ca40">Prize Pool</div><div class="contestCardLabel_7ca40">Entry</div></div><div class="contestSpecRow_01429"><div class="js--contest-card__prize-pool prizePool_565d2"><i class="fas fa-rupee-sign"></i> {{$result->totalWinningPrize}}</div><div><div style="display: flex; align-items: center;"><div class="js--contest-card-join-btn"><button class="new-button smallGreenButton_4bae7"><span><span class="d11-icon"><i class="fas fa-rupee-sign"></i></span><span class="currency-amount"> {{$result->entryFees}}</span></span></button></div></div></div></div></div>
					<div class="progress-container">
										<div class="progress">
					  	<div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="{{$result->totalSpots}}">
						</div>
					</div>
					</div>
					<div class="spotsContainer_9c427"><div class="contestSpecRow_01429"><div class="spotLefts_8d583 contestFilling_14509">{{$result->filledSpots}} spots left</div><div class="totalSpots_b62ba">{{$result->totalSpots}} spots</div></div></div></div><div class="contestSpec_a3ebb"><div class="iconLabelGroup_f55e1"><div class="iconLabelWrapper_43690"><span><i class="fa fa-trophy" style="color:#f58a14;"></i> 50% Winners</span></div></div><div class="iconLabelGroup_f55e1" style="justify-content: flex-end;"><div class="squareWithTwoRoundCorner_1291a confirm-league" data-toggle="tooltip" data-placement="bottom" title="{{$result->cancellation}}" >C</div><div style="padding-left: 12px;"><div class="squareWithTwoRoundCorner_1291a multi-join">M</div></div></div></div></div></a>
					</div>
				</div>
				@endforeach

				
				<div class="row separator">
					
				</div>
				@endforeach
				 
				
				
			</div>
			
		</div>

		<div class="footer">
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-6">
						<div class="joined-contest">
							<a href="joined.html">Joined Contest</a>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="create-team">
							<a href="#">Create Team</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
 @stop