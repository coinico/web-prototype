<div1 class="currency_wrapper" onclick="location.href='{{ url("exchangeDetails?pair=CTF-".$currency->alias) }}'">
    <div class="left-details">
        <a class="vcenter" href="{{ url("exchangeDetails?pair=CTF-".$currency->alias) }}">
            <img class="center_image" src="/images/tokens/{!!$currency->image!!}" />
        </a>
    </div>
    <div class="right-details">
        <div class ="sub_header_type">{!! $headerFor !!}</div>
        <div class ="sub_header_name">{!! $currency->crypto_currency_name." (".$currency->alias.")" !!}</div>
        <div class ="sub_header_volume">{!! number_format($currency->volume, 4, ".", "")." CTF" !!}</div>
        <div class ="sub_header_change">{!! $currency->change_string !!}</div>
    </div>
</div1>