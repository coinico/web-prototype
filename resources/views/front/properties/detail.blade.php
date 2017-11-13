<div class="wrapper">
    <div class="property">
        <div class="info">
            @if( isset($property->images))
                <div class="image" style="background-image: url('images/properties/{{$property->images}}') "></div>
            @else
                <div class="image" style="background-image: url('images/no-image.png') "></div>
            @endif

            <div class="price">U$D {{number_format($property->value, 0, ',', '.')}}</div>
            <div style="margin-top:10px;height: 2px;background: #cbcbcb;position: absolute;content: '';left: 15px;right:15px; "></div>
            <h3 style="margin-top:10px;padding-bottom:0;margin-bottom:-8px;">{{$property->title}}</h3>
            <p2 style="display:inline-block; font-size:12px; margin-top:2px; color:dimgrey;"><img style="display:inline-block; width:13px; " class="location-img" src="/images/icon-location1.png"/> {{strlen($property->city) > 35 ? substr ($property->city, 0, 35)."..." : $property->city}}</p2>
            <div style="height: 2px;background: #838383;position: absolute;content: '';left: 15px;right:15px; "></div>
            <p style="color:dimgrey; margin-top: 10px; margin-bottom: 0;line-height: 21px; font-size:14px; font-weight: lighter; text-align: justify;">{{substr ($property->description, 0, 180)}}...</p>
                @if($property->status_id == 1)
                    <div style="margin-top: 10px; height: 2px;background: #cbcbcb;position: absolute;content: '';left: 15px;right:15px; "></div>

                    <p style="margin-top: 16px; display:inline-block;line-height: 21px; font-size:10px; font-weight: lighter;">
                        <pedo style="color:black; font-size: 15px;">{{number_format($property->getVotingStatus('percentage'), 2, ',', '.')}}%</pedo></br>
                        Estado de Votación
                    </p>
                    <p style="margin-top: 16px; text-align: right; display:inline-block;float:right; line-height: 21px; font-size:10px; font-weight: lighter;">
                        <pedo style="color:black; font-size: 15px;">{{$property->getPositiveVotes()}}</pedo></br>
                        Votos
                    </p></br>
                    <div style="margin-top: -28px; height: 1px;background: #cbcbcb;content: '';left: 15px;right:15px; "></div>
                @else
                @endif
        </div>
        <div class="hover">
            @if($property->status_id == 1)
            <div class="time_left">
                <div><span class="days"> {{$property->getVotingTime()->d}} </span> <small>dias</small></div>
                <div><span class="hs">{{$property->getVotingTime()->h}}</span> <small>hs</small></div>
                <div><span class="min">{{$property->getVotingTime()->i}}</span> <small>min</small></div>
            </div>
            <div class="vote" data-url="property/{{ $property->id }}/vote">
                <div class="up">
                    <a href="#" class="{{($property->getUserVote()==1) ? 'selected' : ''}}"> <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> </a>
                    <small>{{$property->getPositiveVotes()}}</small>
                </div>
                <div class="down">
                    <a href="#" class="{{($property->getUserVote()==-1)? 'selected' : ''}}"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i> </a>
                    <small>{{$property->getNegativeVotes()}}</small>
                </div>
            </div>
            <a href="properties/{{$property->id}}">Ampliar</a>
            @else
            <div class="time_left">
                <div><span class="days"> {{$property->getInvestmentTime()->d}} </span> <small>dias</small></div>
                <div><span class="hs">{{$property->getInvestmentTime()->h}}</span> <small>hs</small></div>
                <div><span class="min">{{$property->getInvestmentTime()->i}}</span> <small>min</small></div>
            </div>
            @guest
            </br></br>
            <span><a href="{{ route('login') }}">INVERTIR</a></span>
            @else
            <div class="invest" data-url="property/{{ $property->id }}/invest">
                <span>INVERTIR</span>
                <fieldset>
                    <input type="number" value="{{$property->getUserInvestment()}}" name="value"/>
                    <a href="#">
                        <small>ETH</small>
                        <i class="fa fa-paper-plane" aria-hidden="true"></i>
                    </a>
                </fieldset>
            </div>
            @endguest
            <a href="properties/{{$property->id}}">Ampliar</a>
            @endif
        </div>
    </div>
</div>