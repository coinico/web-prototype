@extends('back.properties.template')

@section('form-open')
    <form method="post" action="{{ route('properties.update', [$property->id]) }}">
        {{ method_field('PUT') }}
@endsection
