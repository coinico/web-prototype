<div class="wallet-wrapper">
    <div class="wallet">
        <div class="left-details">
            <a href="{{ url("userWallet/$tokenWallet->id/manage") }}">
                <img src="/images/tokens/{!!$tokenWallet->currency->image!!}" />
                <p class="currency_name">{{$tokenWallet->currency->name}}</p>
            </a>
        </div>
        <div class="right-details">
            <img src="/images/wallets/qr_code.png" />
            <p class="address"></p>

        </div>
        <div class="middle-details">
            <p class="available_balance">Balance Disponible</p>
            <p class="balance">{!!number_format($tokenWallet->transactions->sum( 'amount' ), 8, '.', '')!!}</p>
            <button class="manage_button" onclick="window.location='{{ url("userWallet/$tokenWallet->id/manage") }}'">Administrar</button>
        </div>
    </div>
</div>