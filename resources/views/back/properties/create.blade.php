@extends('back.properties.template')

@section('form-open')
    <form method="post" action="{{ route('properties.store') }}">
@endsection