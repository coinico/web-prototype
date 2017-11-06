@extends('back.layout')

@section('css')
    <style>
        textarea { resize: vertical; }
    </style>
    <link href="{{ asset('adminlte/plugins/colorbox/colorbox.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css">

@endsection

@section('main')

    @yield('form-open')
        {{ csrf_field() }}

        <div class="row">

            <div class="col-md-8">
                @if (session('crypto_currency-ok'))
                    @component('back.components.alert')
                        @slot('type')
                            success
                        @endslot
                        {!! session('crypto_currency-ok') !!}
                    @endcomponent
                @endif
                @include('back.partials.boxinput', [
                    'box' => [
                        'type' => 'box-primary',
                        'title' => __('Nombre'),
                    ],
                    'input' => [
                        'name' => 'name',
                        'value' => isset($cryptoCurrency) ? $cryptoCurrency->name : '',
                        'input' => 'text',
                        'required' => true,
                    ],
                ])
            </div>

            <div class="col-md-4">
                @component('back.components.box')
                @slot('type')
                danger
                @endslot
                @slot('boxTitle')
                @lang('Alias')
                @endslot
                @include('back.partials.boxinput', [
                    'box' => [
                        'type' => 'box-primary',
                        'title' => __('Alias'),
                    ],
                    'input' => [
                        'name' => 'alias',
                        'value' => $cryptoCurrency->alias,
                        'input' => 'text',
                        'required' => true,
                    ],
                ])
                @endcomponent
            </div>

            <div class="col-md-4">
                @component('back.components.box')
                    @slot('type')
                        danger
                    @endslot
                    @slot('boxTitle')
                        @lang('Image')
                    @endslot
                    @include('back.partials.boxinput', [
                        'box' => [
                            'type' => 'box-primary',
                            'title' => __('Image'),
                        ],
                        'input' => [
                            'name' => 'image',
                            'value' => $cryptoCurrency->image,
                            'input' => 'text',
                            'required' => true,
                        ],
                    ])
                @endcomponent
            </div>

            <div class="col-md-4">
                @component('back.components.box')
                    @slot('type')
                        danger
                    @endslot
                    @slot('boxTitle')
                        @lang('Valor Dólar')
                    @endslot
                    @include('back.partials.boxinput', [
                        'box' => [
                            'type' => 'box-primary',
                            'title' => __('Valor dólar'),
                        ],
                        'input' => [
                            'name' => 'usd_value',
                            'value' => $cryptoCurrency->usd_value,
                            'input' => 'integer',
                            'required' => true,
                        ],
                    ])
                @endcomponent
            </div>

            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">@lang('Guardar')</button>
            </div>

        </div>
        <!-- /.row -->
    </form>

@endsection

@section('js')


@endsection