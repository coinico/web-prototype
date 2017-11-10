<div class="wrapper">
    <div class="property">
        <div class="info">
            @if( isset($property->images))
                <div class="image" style="background-image: url('images/properties/{{$property->images}}') "></div>
            @else
                <div class="image" style="background-image: url('images/no-image.png') "></div>
            @endif

            <div class="price">U$D {{number_format($property->value, 0, ',', '.')}}</div>
            <h3>{{$property->title}}</h3>
            <p>{{substr ($property->description, 0, 130)}}...</p>
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
            <a href="properties/{{$property->id}}">Ampliar</a>
            @endif
        </div>
    </div>
</div>