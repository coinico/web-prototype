<div class="wallet-wrapper">
    <div class="wallet">
        <div class="left-details">
            <img src="/images/tokens/{!!$tokenWallet->currency->image!!}" />
            <p class="currency_name">{{$tokenWallet->currency->name}}</p>
        </div>
        <div class="right-details">
            <img src="/images/wallets/qr_code.png" />
            <p class="address"></p>

        </div>
        <div1 class="middle-details">
            <p1 class="available_balance">Balance Disponible</p1>
            <p1 class="balance">{!!number_format($tokenWallet->transactions->sum( 'amount' ), 8, '.', '')!!}</p1>
            <button class="manage_button">Administrar</button>
        </div1>
    </div>
</div>