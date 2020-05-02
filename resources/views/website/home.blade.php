@extends('layouts.master') 
    @section('content') 


    <div class="app-container">
		
		@include('partial.navigation')
		
		<div class="content" style="padding-top:70px;">
			<div class="container">
				<div class="row" style="margin-bottom:10px;">
					<div class="col-sm-12 text-center">
						<img src="{{ url('assets/img/slide3.png') }}" alt="">
					</div>
				</div>
				
				@foreach($matches->matchdata as $key => $result)
				@if($result['viewType']==3)
				@foreach($result['upcomingmatches'] as $match)
				<div class="row">
					<div class="col-sm-12">
						<div class="matches-container">
							<div class="full-match-card-container">
								<a class="match-card-content-container" href="{{url('contest')}}?match_id={{$match->match_id}}">
									<div class="match-card-header">{{$match->title}}</div>
									<div class="match-card-primary-container">
									<div class="squad-container">
									<div class="squad-color-ribbon" style="background-color: rgb(196, 96, 100);"></div> 
									@if($match->teama->logo_url)
									<img class="squad-logo" src="{{ url($match->teama->logo_url) }}" alt="{{$match->teama->name}}" style="border-radius: 30px; border: 1px solid #{{substr(md5(rand()), 0, 6)}};
										background-color: #{{substr(md5(rand()), 0, 6)}}
										">
									@else
									<p style="
									background: #fff !important;
									position: absolute;
									left: 27px;
									height: 55px;
									width: 55px;
									padding: 12px;
									text-align: center;
									border:2px solid #ccc;
									border-radius: 32px;transform:inherit;
									">{{$match->teama->short_name}} </p> 
									@endif

									<div class="squad-info" style="position: absolute;right: 0px;">
									<div class="squad-name reaction-placeholder">{{$match->teama->short_name}}</div>
									</div>
									</div>
									<div class="not-started-time">
									<div>{!!date('H:i A',$match->timestamp_start)!!}</div><div> {!!date('D, d M, Y',$match->timestamp_start) !!}
									</div>
									</div>
									<div class="squad-container away">
									<div class="squad-color-ribbon" style="background-color: rgb(189, 81, 99);" ></div>
									@if($match->teamb->logo_url)
									<img class="squad-logo" src="{{ url($match->teamb->logo_url) }}" alt="{{$match->teamb->name}}" style="border-radius: 30px;
									border: 1px solid #{{substr(md5(rand()), 0, 6)}};
										background-color: #{{substr(md5(rand()), 0, 6)}}
									">
									@else
									<p style="
									background: #fff !important;
									position: absolute;
									left: 27px;
									height: 55px;
									width: 55px;
									border:2px solid ;
									padding: 12px;
									text-align: center;
									border-radius: 32px;transform:inherit;
									">{{$match->teamb->short_name}} </p> 
									@endif
									<div class="squad-info" style="position: absolute;right: 0px;">
									<div class="squad-name reaction-placeholder">{{$match->teamb->short_name}}</div>
									</div></div></div>
									<div class="match-card-footer" id="timer_{{$match->match_id}}"> 
										<script type="text/javascript">
											getTimer('timer_{{$match->match_id}}', "{{$match->date_start}}");
										</script>
									</div>
								</a>
							</div>
						</div>
					</div>
				</div>
				@endforeach
				@endif
				@endforeach
				 
				
			</div>
			
		</div>
@stop