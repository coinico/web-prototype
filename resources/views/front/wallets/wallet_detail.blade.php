<div class="wallet-wrapper">
    <div class="wallet">
        <div class="left-details">
            <a class="tapioca" href="{{ url("userWallet/$standardWallet->id/manage") }}">
                <img src="/images/{!!$standardWallet->currency->image!!}" />
                 <p class="currency_name">{{$standardWallet->currency->name}}</p>
            </a>
        </div>
        <div class="right-details">
            <img src="/images/wallets/qr_code.png" />
            <p class="address"></p>

        </div>
        <div class="middle-details">
            <p class="available_balance">Balance Disponible</p>
            <p1 class="balance">{!!number_format($standardWallet->transactions->sum( 'amount' ), 8, '.', '')!!}</p1>
            <button class="manage_button" onclick="window.location='{{ url("userWallet/$standardWallet->id/manage") }}'">Administrar</button>
        </div>
    </div>
</div>