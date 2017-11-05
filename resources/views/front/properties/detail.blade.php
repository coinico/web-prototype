<div class="wrapper">
    <div class="property">
        <div class="info">
            @if( isset($property->images{0}))
                <div class="image" style="background-image: url('{{asset('images/properties/'.$property->images{0}->property_id.'/'.$property->images{0}->file_name) }}') "></div>
            @else
                <div class="image" style="background-image: url('images/no-image.png') "></div>
            @endif

            <div class="price">$ 2500</div>
            <h3>{{$property->title}}</h3>
            <h1>Amazing view, jacuzzi and terrace</h1>
            <span>1500</span>
        </div>
        <div class="hover">
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
        </div>
    </div>
</div>