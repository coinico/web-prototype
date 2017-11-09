<a href="{{url("userWallet/$tokenWallet->id/manage")}}" class="item">
    <img src="images/tokens/{!!$tokenWallet->currency->image!!}" />
    <span> {{$tokenWallet->currency->name}} </span>
    <div class="detail">
        <span>{!!number_format($tokenWallet->transactions->sum( 'amount' ), 8, '.', '')!!} </span>
        <small>{{$tokenWallet->currency->usd_value * $tokenWallet->transactions->sum( 'amount' )}} USD </small>
    </div>
</a>
