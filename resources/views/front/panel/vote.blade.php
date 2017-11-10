<?php $property = $vote->property(); ?>
<a href="{{url("properties/$vote->property_id")}}" class="item">
    <img src="/images/house.png" />
    <span> {{$property->title}} </span>
    <div class="detail">
        @if($vote->vote == 1)
            <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
        @else
            <i class="fa fa-thumbs-o-down" aria-hidden="true"></i>
        @endif
    </div>
</a>
