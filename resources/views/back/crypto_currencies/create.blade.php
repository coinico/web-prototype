@extends('back.crypto_currencies.template')

@section('form-open')
    <form method="post" action="{{ route('crypto_currencies.store') }}">
@endsection