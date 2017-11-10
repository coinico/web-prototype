<a href="{{url("userWallet/$standardWallet->id/manage")}}" class="item">
    <img src="images/{!!$standardWallet->currency->image!!}" />
    <span> {{$standardWallet->currency->name}} </span>
    <div class="detail">
        <span>{!!number_format($standardWallet->transactions->sum( 'amount' ), 8, '.', '')!!} </span>
        <small>{{$standardWallet->currency->usd_value * $standardWallet->transactions->sum( 'amount' )}} USD </small>
    </div>
</a>
