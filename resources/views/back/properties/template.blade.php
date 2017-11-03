@extends('back.layout')

@section('css')
    <style>
        textarea { resize: vertical; }
    </style>
    <link href="{{ asset('adminlte/plugins/colorbox/colorbox.css') }}" rel="stylesheet">
@endsection

@section('main')

    @yield('form-open')
        {{ csrf_field() }}

        <div class="row">

            <div class="col-md-8">
                @if (session('property-ok'))
                    @component('back.components.alert')
                        @slot('type')
                            success
                        @endslot
                        {!! session('property-ok') !!}
                    @endcomponent
                @endif
                @include('back.partials.boxinput', [
                    'box' => [
                        'type' => 'box-primary',
                        'title' => __('Title'),
                    ],
                    'input' => [
                        'name' => 'title',
                        'value' => isset($property) ? $property->title : '',
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
                @lang('Status')
                @endslot
                @include('back.partials.input', [
                    'input' => [
                        'name' => 'status_id',
                        'value' => $property->status->id,
                        'input' => 'select',
                        'options' => $status,
                    ],
                ])
                @endcomponent
            </div>

            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">@lang('Submit')</button>
            </div>

        </div>
        </div>
        <!-- /.row -->
    </form>

@endsection

@section('js')

    <script src="{{ asset('adminlte/plugins/colorbox/jquery.colorbox-min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/voca/voca.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
    <script>

        CKEDITOR.replace('body', {customConfig: '/adminlte/js/ckeditor.js'})

        $('.popup_selector').click( function (event) {
            event.preventDefault()
            var updateID = $(this).attr('data-inputid')
            var elfinderUrl = '/elfinder/popup/'
            var triggerUrl = elfinderUrl + updateID
            $.colorbox({
                href: triggerUrl,
                fastIframe: true,
                iframe: true,
                width: '70%',
                height: '70%'
            })
        })

        function processSelectedFile(filePath, requestingField) {
            $('#' + requestingField).val('\\' + filePath)
            $('#img').attr('src', '\\' + filePath)
        }

        $('#slug').keyup(function () {
            $(this).val(v.slugify($(this).val()))
        })

        $('#title').keyup(function () {
            $('#slug').val(v.slugify($(this).val()))
        })

    </script>

@endsection