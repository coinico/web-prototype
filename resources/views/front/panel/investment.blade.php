<?php $property = $investment->property(); ?>
<a href="{{url("properties/$investment->property_id")}}" class="item">
    <img src="/images/house.png" />
    <span> {{$property->title}} </span>
    <div class="detail">
        <span>{!!number_format($property->getUserInvestment(), 2, ',', '.')!!} </span>
        <small>{{number_format($property->getUserInvestment('usd'), 2, ',', '.')}} USD </small>
    </div>
</a>
