@extends('back.crypto_currencies.template')

@section('form-open')
    <form method="post" action="{{ route('crypto_currencies.update', [$cryptoCurrency->id]) }}">
        {{ method_field('PUT') }}
@endsection
