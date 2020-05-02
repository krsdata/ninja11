<div class="main-header">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4 pro-pic">
                         
                        @if(isset($page_title))
                         <a href="{{url('getMatch')}}"><i class="fas fa-chevron-left"></i></a>
                        @else
                            <img src="{{ url('assets/img/avtar.png') }}" alt="Ninjas11">
                        @endif
                    </div>
                    <div class="col-sm-4 text-center">
                        <h4>{{$page_title??'Ninjas11' }}</h4>
                    </div>
                    <div class="col-sm-4">
                        <a href="{{url('logout')}}"><i class="fas fa-power-off" style="font-size: 26px;float: right;line-height: inherit;margin-left: 9px;"></i></a> 
                        <a href="{{url('wallet')}}"><i class="fas fa-wallet"></i></a>
                        
                    </div>
                </div>  

            </div>
            
        </div>