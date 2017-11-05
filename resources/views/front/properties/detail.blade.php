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
                <span>05 <small>dias</small></span>
                <span>11 <small>hs</small></span>
                <span>23 <small>min</small></span>
            </div>
            <div class="vote">
                <div class="up">
                    <a href="#"> <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> </a>
                    <small>503</small>
                </div>
                <div class="down">
                    <a href="#"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i> </a>
                    <small>87</small>
                </div>
            </div>
            <a href="properties/{{$property->id}}">Ampliar</a>
        </div>
    </div>
</div>