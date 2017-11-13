<div class="item">
    <span>
        <strong>ORIGEN:</strong> {{$transaction->address_from}} <br>
        <strong>DESTINO:</strong> {{$transaction->address_to}} <br>
        <strong>MONTO: </strong>{{$transaction->amount}}<br>
        <strong>DESCRIPCIÓN: </strong>{{$transaction->memo}}
    </span>
    <div class="detail">
        <?php $date = new DateTime($transaction->created_at) ?>
        <span>{{$date->format('d/m/Y')}}</span>
    </div>
</div>
