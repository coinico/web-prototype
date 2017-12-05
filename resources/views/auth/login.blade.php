@extends('front.layout')

@section('main')
   <section id="content-wrap">
        <div class="row">
            <div class="col-twelve">
                <div class="primary-content">
                    @if (session('confirmation-success'))
                        @component('front.components.alert')
                            @slot('type')
                                success
                            @endslot
                            {!! session('confirmation-success') !!}
                        @endcomponent
                    @endif
                    @if (session('confirmation-danger'))
                        @component('front.components.alert')
                            @slot('type')
                                error
                            @endslot
                            {!! session('confirmation-danger') !!}
                        @endcomponent
                    @endif
                        <h3>@lang('Ingresar')</h3>
                        <p>@lang('Para ingresar deberás estar registrado, y para ello tendrás que proveer un e-mail y tu nombre.')</br>Si aún no te encuentras registrado haz click <a href="{{ route('register') }}">@lang('aquí')</a>.</p>
                    <form role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        @if ($errors->has('log'))
                            @component('front.components.error')
                                {{ $errors->first('log') }}
                            @endcomponent
                        @endif   
                        <input id="log" type="text" placeholder="@lang('E-mail')" class="full-width" name="log" value="{{ old('log') }}" required autofocus>
                        <input class="button-primary full-width-on-mobile" type="submit" value="@lang('Ingresar')">
                        <input type="hidden" id="password" name="password" value="admin">
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
