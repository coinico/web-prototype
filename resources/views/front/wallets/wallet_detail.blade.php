<div class="wallet-wrapper">
    <div class="wallet">
        <div class="left-details">
            <a href="javascript:walletOnClick()">
                <img src="/images/{!!$standardWallet->currency->image!!}" />
            </a>
            <p class="currency_name">{{$standardWallet->currency->name}}</p>
        </div>
        <div class="right-details">
            <img src="/images/wallets/qr_code.png" />
            <p class="address"></p>

        </div>
        <div1 class="middle-details">
            <p1 class="available_balance">Balance Disponible</p1>
            <p1 class="balance">{!!number_format($standardWallet->available_balance, 8, ',', '.')!!}</p1>
            <p1 class="transaction_history">Historial de Transacciones</p1>
        </div1>
    </div>
</div>