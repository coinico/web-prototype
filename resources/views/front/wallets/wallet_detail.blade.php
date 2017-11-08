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
        <div class="middle-details">
            <p class="available_balance">Balance Disponible</p>
            <p class="balance">{!!number_format($standardWallet->available_balance, 8, '.', ',')!!}</p>
            <p class="transaction_history">Historial de Transacciones</p>
        </div>
    </div>
</div>