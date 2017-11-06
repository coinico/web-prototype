@extends('back.layout')

@section('css')
    <link rel="stylesheet" href="//cdn.jsdelivr.net/sweetalert2/6.3.8/sweetalert2.min.css">
    <style>
        input, th span {
            cursor: pointer;
        }
    </style>
@endsection

@section('button')
    <a href="{{ route('crypto_currencies.create') }}" class="btn btn-primary">@lang('Nueva Crypto Currency')</a>
@endsection

@section('main')

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <strong>@lang('Mostrar') :</strong> &nbsp;
                    <input type="checkbox" name="new" @if(request()->new) checked @endif> @lang('Nueva')&nbsp;


                    <div id="spinner" class="text-center"></div>
                </div>
                <div class="box-body table-responsive">
                    <table id="users" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>@lang('Nombre')<span id="name" class="fa fa-sort pull-right"
                                                              aria-hidden="true"></span></th>
                            <th>@lang('Alias')<span id="alias" class="fa fa-sort pull-right"
                                                    aria-hidden="true"></span></th>
                            <th>@lang('Image')<span id="image" class="fa fa-sort pull-right"
                                                              aria-hidden="true"></span></th>
                            <th>@lang('Valor USD')<span id="usd_value" class="fa fa-sort-desc pull-right"
                                                              aria-hidden="true"></span></th>
                            <th>@lang('Nuevo')</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>@lang('Nombre')</th>
                            <th>@lang('Alias')</th>
                            <th>@lang('Image')</th>
                            <th>@lang('Valor USD')</th>
                            <th>@lang('New')</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </tfoot>
                        <tbody id="pannel">
                            @if (session('crypto_currency-ok'))
                                @component('back.components.alert')
                                    @slot('type')
                                        success
                                    @endslot
                                    {!! session('crypto_currency-ok') !!}
                                @endcomponent
                            @endif
                            @include('back.crypto_currencies.table', compact('crypto_currencies'))
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div id="pagination" class="box-footer">
                    {{ $links }}
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

@endsection

@section('js')
    <script src="{{ asset('adminlte/js/back.js') }}"></script>
    <script>

        var cryptoCurrency = (function () {

            var url = '{{ route('properties.index') }}'
            var swalTitle = '@lang('Seguro deseas borrar la crypto-moneda?')'
            var confirmButtonText = '@lang('Yes')'
            var cancelButtonText = '@lang('No')'
            var errorAjax = '@lang('Parece que hubo un error...')'

            var onReady = function () {
                $('#pagination').on('click', 'ul.pagination a', function (event) {
                    back.pagination(event, $(this), errorAjax)
                })
                $('#pannel').on('change', ':checkbox[name="seen"]', function () {
                        back.seen(url, $(this), errorAjax)
                    })
                    .on('change', ':checkbox[name="status"]', function () {
                        back.status(url, $(this), errorAjax)
                    })
                    .on('click', 'td a.btn-danger', function (event) {
                        back.destroy(event, $(this), url, swalTitle, confirmButtonText, cancelButtonText, errorAjax)
                    })
                $('th span').click(function () {
                    back.ordering(url, $(this), errorAjax)
                })
                $('.box-header :radio, .box-header :checkbox').click(function () {
                    back.filters(url, errorAjax)
                })
            }

            return {
                onReady: onReady
            }

        })()

        $(document).ready(cryptoCurrency.onReady)

    </script>
@endsection