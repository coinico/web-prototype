@extends('front.layout')

@section('main')

   <!-- content
   ================================================== -->
   <section id="content-wrap" class="site-page">
   	<div class="row">
   		<div class="col-twelve">

   			<section>  

                <div class="primary-content">

						<h1 class="entry-title add-bottom">@lang('Contactanos')</h1>

                        @if (session('ok'))
                            @component('front.components.alert')
                                @slot('type')
                                    success
                                @endslot
                                {!! session('ok') !!}
                            @endcomponent
                        @endif

						<form method="post" action="{{ route('contacts.store') }}">
                            {{ csrf_field() }}
                            @if ($errors->has('name'))
                                @component('front.components.error')
                                    {{ $errors->first('name') }}
                                @endcomponent
                            @endif 
                            <input id="name" placeholder="@lang('Tu nombre')" type="text" class="full-width"  name="name" value="{{ old('name') }}" required autofocus>
                            @if ($errors->has('email'))
                                @component('front.components.error')
                                    {{ $errors->first('email') }}
                                @endcomponent
                            @endif 
                            <input id="email" placeholder="@lang('Tu email')" type="email" class="full-width"  name="email" value="{{ old('email') }}" required>
                            @if ($errors->has('message'))
                                @component('front.components.error')
                                    {{ $errors->first('message') }}
                                @endcomponent
                            @endif 
                            <textarea name="message" id="message" class="full-width" placeholder="@lang('Tu mensaje')" ></textarea>
                            <button type="submit" class="submit button-primary full-width-on-mobile">Enviar</button>
  				        </form> <!-- end form -->
                    </div>
			</section>
   		   		
		</div> <!-- end col-twelve -->
   	</div> <!-- end row -->
   </section> <!-- end content --> 
      
@endsection