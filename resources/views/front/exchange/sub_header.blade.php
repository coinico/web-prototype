<div1 class="currency_wrapper" onclick="location.href='{{ url("exchangeDetails?pair=".$currency->crypto_currency_from."-".$currency->alias) }}'">
    <div class="left-details">
        <a class="vcenter" href="{{ url("exchangeDetails?pair=".$currency->crypto_currency_from."-".$currency->alias) }}">
            <img class="center_image" src="/images/{!!$currency->typex === "token" ? "tokens/".$currency->image : $currency->image !!}" />
        </a>
    </div>
    <div class="right-details">
        <div class ="sub_header_type">{!! $headerFor !!}</div>
        <div class ="sub_header_name">{!! $currency->crypto_currency_name." (".$currency->alias.")" !!}</div>
        <div class ="sub_header_volume">{!! number_format($currency->volume, 4, ".", "")." ".$currency->crypto_currency_from !!}</div>
        <div class ="sub_header_change {{$currency->change_percent > 0 ? "sub_header_change_green": ($currency->change_percent < 0 ? "sub_header_change_red" :"")}}"><img class="arrow_percent" src="/images/{{$currency->change_percent > 0 ? "up_arrow.png": ($currency->change_percent < 0 ? "down_arrow.png" : "leftandright.png")}} "> {!! $currency->change_string !!}</div>
    </div>
</div1>