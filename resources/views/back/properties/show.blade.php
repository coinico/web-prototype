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
                    {{ $property->id }}
                    <hr>
                    <p>@lang('Title')</p>
                    {{ $property->title }}
                    <hr>
                    <p>@lang('Author')</p>
                    {{ $property->user->name }}
                    <hr>
                    <p>@lang('Slug')</p>
                    {{ $property->slug }}
                    <hr>
                    <p>@lang('Status')</p>
                    {{ $property->active ? __('Active') : __('No Active')}}
                    <hr>
                    <p>@lang('Date Creation')</p>
                    {{ $property->created_at->formatLocalized('%c') }}
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