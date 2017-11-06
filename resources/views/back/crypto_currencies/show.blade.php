@extends('back.layout')

@section('css')
    <style>
        .box-body hr+p {
            font-size: x-large;
        }
    </style>
@endsection


@section('main')

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <hr>
                    <p>ID</p>
                    {{ $cryptoCurrency->id }}
                    <hr>
                    <p>@lang('Nombre')</p>
                    {{ $cryptoCurrency->name }}
                    <hr>
                    <p>@lang('Alias')</p>
                    {{ $cryptoCurrency->alias }}
                    <hr>
                    <p>@lang('Image')</p>
                    {{ $cryptoCurrency->image }}
                    <hr>
                    <p>@lang('Valor USD')</p>
                    {{ $cryptoCurrency->usd_value }}
                    <hr>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

@endsection