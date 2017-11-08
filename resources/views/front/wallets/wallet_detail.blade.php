<div class="wallet-wrapper">
    <div class="wallet">
        <div class="left-details">
            <img src="/images/{!!$standardWallet->currency->image!!}" />
            <p class="currency_name">{{$standardWallet->currency->name}}</p>
        </div>
        <div class="right-details">
            <img src="/images/wallets/qr_code.png" />
            <p class="address"></p>

        </div>
        <div1 class="middle-details">
            <p1 class="available_balance">Balance Disponible</p1>
            <p1 class="balance">{!!number_format($standardWallet->transactions->sum( 'amount' ), 8, ',', '.')!!}</p1>
            <p1 class="transaction_history">Historial de Transacciones</p1>
        </div1>
    </div>
</div>