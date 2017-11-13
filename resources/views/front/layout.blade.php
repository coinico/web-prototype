<!DOCTYPE html>
<!--[if IE 8 ]><html class="no-js oldie ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="no-js oldie ie9" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html class="no-js" lang="{{ config('app.locale') }}"> <!--<![endif]-->
<head>

	<!--- basic page needs
	================================================== -->
	<meta charset="utf-8">
	<title>{{ isset($post) && $post->seo_title ? $post->seo_title :  __(lcfirst('CasaToken')) }}</title>
	<meta name="description" content="{{ isset($post) && $post->meta_description ? $post->meta_description : __('description') }}">
	<meta name="author" content="@lang(lcfirst ('Author'))">
	@if(isset($post) && $post->meta_keywords)
		<meta name="keywords" content="{{ $post->meta_keywords }}">
	@endif
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- mobile specific metas
	================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- CSS
	================================================== -->
	<link rel="stylesheet" href="{{ asset('css/base.css') }}">
	<link rel="stylesheet" href="{{ asset('css/vendor.css') }}">
	<link rel="stylesheet" href="{{ asset('css/main.css') }}">
	<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
	<link rel="stylesheet" href="{{ asset('css/plugins/introjs.css') }}">

	@yield('css')

	<style>
		.search-wrap .search-form::after {
			content: "@lang('Press Enter to begin your search.')";
		}
	</style>


	<!-- script
	================================================== -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>

	<!-- favicons
	================================================== -->
	<link rel="shortcut icon" href="{{ asset('images/casatoken.ico') }}" type="image/x-icon"/>
	<link rel="icon" href="{{ asset('images/casatoken.ico') }}" type="image/x-icon">

</head>

<body id="top">

	<!-- header
   ================================================== -->
   <header class="short-header">

   	<div class="gradient-block"></div>

   	<div class="row header-content">

   		<div class="logo">
	    	<a id="marvin-el-loco" href="http://casatoken.io">CasaToken.io</a>
	    </div>

	   	<nav id="main-nav-wrap">
			<ul class="main-navigation sf-menu">
				<li {{ currentRoute('home') }}>
					<a class="{{isHome() ? 'smoothscroll' : ''}}" href="{{isHome() ? '#top' : route('home')}}">@lang('Demo')</a>
				</li>
			@guest
					<li {{ currentRoute('owners') }}>
						<a class="{{isHome() ? 'smoothscroll' : ''}}" href="{{isHome() ? '' : route('home')}}#second-stop">@lang('Propietarios')</a>
					</li>
					<li {{ currentRoute('community') }}>
						<a class="{{isHome()? 'smoothscroll' : ''}}" href="{{isHome() ? '' : route('home')}}#fifth-stop">@lang('Comunidad')</a>
					</li>
                    <li {{ currentRoute('investors') }}>
                        <a class="{{isHome() ? 'smoothscroll' : ''}}" href="{{isHome() ? '' : route('home')}}#third-stop">@lang('Inversores')</a>
                    </li>
                @else
					<li>
						<a href="javascript:alert('Opción no disponible en la demo.');">@lang('Enlistar')</a>
					</li>
					<li {{ currentRoute('community') }}>
						<a href="{{route('community')}}">@lang('Votar')</a>
					</li>
                    <li {{ currentRoute('investors') }}>
                        <a href="{{route('investors')}}">@lang('Invertir')</a>
                    </li>
                @endguest

				@guest
					<li {{ currentRoute('exchange') }}>
						<a class="{{isHome() ? 'smoothscroll' : ''}}" href="{{isHome() ? '#fourth-stop' : route('exchange')}}">@lang('Exchange')</a>
					</li>
				@else
					<li {{ currentRoute('orders') }}>
						<a href="{{route('orders')}}">@lang('Ordenes')</a>
					</li>
					<li {{ currentRoute('exchange') }}>
						<a href="{{route('exchange')}}">@lang('Exchange')</a>
					</li>
				@endguest

                @guest
                @else
                @endguest


				@request('register')
					<li class="current">
						<a href="{{ request()->url() }}">@lang('Registrarme')</a>
					</li>
				@endrequest
				@request('password/email')
					<li class="current">
						<a href="{{ request()->url() }}">@lang('Contraseña olvidada')</a>
					</li>
				@else
					@guest
						<li {{ currentRoute('login') }}>
							<a href="{{ route('login') }}">@lang('Ingresar')</a>
						</li>
						@request('password/reset')
							<li class="current">
								<a href="{{ request()->url() }}">@lang('Contraseña')</a>
							</li>
						@endrequest
						@request('password/reset/*')
							<li class="current">
								<a href="{{ request()->url() }}">@lang('Contraseña')</a>
							</li>
						@endrequest
					@else
						<li class='cat-item'>
							<div class="user-lnk">
								<a class="atata" href='#' title='Usuario'>Mi Usuario</a>
								<a class="atata1" href='#' title='Usuario'><img src="/images/user-icon.svg" /></a>
							</div>
							<ul class="children">
								<li {{ currentRoute('panel') }}>
									<a href="{{ route('panel') }}">@lang('Panel')</a>
								</li>
								<li {{ currentRoute('wallets.index') }}>
									<a href="{{ route('wallets.index') }}" id="billetera_btn">@lang('Billetera')</a>
								</li>
								<li>
									<a id="logout" href="{{ route('logout') }}">@lang('Salir')</a>
									<form id="logout-form" action="{{ route('logout') }}" method="POST" class="hide">
										{{ csrf_field() }}
									</form>
								</li>
							</ul>
						</li>
					@endguest
				@endrequest
			</ul>
		</nav> <!-- end main-nav-wrap -->

		<div class="search-wrap">
			<form role="search" method="get" class="search-form" action="{{ route('posts.search') }}">
				<label>
					<input type="search" class="search-field" placeholder="@lang('Type Your Keywords')"  name="search" autocomplete="off" required>
				</label>
				<input type="submit" class="search-submit" value="">
			</form>

			<a href="#" id="close-search" class="close-btn">Close</a>

		</div> <!-- end search wrap -->

		<div class="triggers">
			<a class="menu-toggle" href="#"><span>Menu</span></a>
		</div> <!-- end triggers -->

   	</div>

   </header> <!-- end header -->

   @yield('main')
	@if (!isHome())
   <!-- footer
   ================================================== -->
   <footer>


   	<div class="footer-main">

   		<div class="row">

	      	<div class="col-twelve tab-full mob-full footer-info">

	            <h4 style="color:#4e638a;">@lang('Acerca de este DEMO')</h4>

	               <p>Esta versión es un prototipo de demostración para ilustrar algunas de las funcionalidades básicas, a modo de ejemplo del plan de desarrollo delineado en nuestro white-paper y modelo de negocios. El desarrollo de la plataforma seguirá las etapas descriptas en nuestro roadmap luego del cierre del período de contribución anunciado en la ICO.
					   Suscríbete a nuestra lista de distribución para recibir información de nuestros avances (<a href="http://casatoken.io/#About">LINK</a>).</p>

		      </div> <!-- end footer-info -->

		</div> <!-- end footer-main -->

	   <div class="footer-bottom" style="margin-top:-40px;margin-bottom:-40px;background-color: #f5f5f5!important">
		   <div class="row">

			   <span style="font-family: 'Lato',Helvetica,Arial,Lucida,sans-serif; display: inline-block; float:left; color:#0a131b; font-weight: bold; font-size: 13px;">COPYRIGHT © 2017 CASATOKEN. ALL RIGHTS RESERVED. TERMS OF USE PRIVACY POLICY</span>
			   <div class="copyright" style="display: inline-block; color:#0a131b; float:right;">
				   <span><a style="display: inline-block; color:#0a131b; font-size: 32px;font-weight: bold; " href="https://twitter.com/casatoken"><i class="fa fa-twitter"></i> </a></span>
				   <span><a style="display: inline-block; color:#0a131b; font-size: 32px;font-weight: bold; " href="https://www.facebook.com/CasaToken-136200837022798"><i class="fa fa-facebook"></i></a></span>
				   <span><a style="display: inline-block; color:#0a131b; font-size: 32px;font-weight: bold; " href="https://www.instagram.com/casatoken/"><i class="fa fa-instagram"></i></a></span>
			   </div>

			   <div id="go-top">
				   <a class="smoothscroll" title="Back to Top" href="#top"><i class="icon icon-arrow-up"></i></a>
			   </div>
		   </div>
	   </div> <!-- end footer-bottom -->
   </footer>

	   @else

   <footer style="background-color: #0a131b!important;">
      <div class="footer-bottom" style="margin-top:-40px;margin-bottom:-40px;background-color: #0a131b!important">
      	<div class="row">

			<span style="    font-family: 'Lato',Helvetica,Arial,Lucida,sans-serif; display: inline-block; float:left; color:white; font-weight: bold; font-size: 13px;">COPYRIGHT © 2017 CASATOKEN. ALL RIGHTS RESERVED. TERMS OF USE PRIVACY POLICY</span>
			<div class="copyright" style="display: inline-block; color:white; float:right;">
				<span><a style="display: inline-block; color:white; font-size: 32px;font-weight: bold; " href="https://twitter.com/casatoken"><i class="fa fa-twitter"></i> </a></span>
				<span><a style="display: inline-block; color:white; font-size: 32px;font-weight: bold; " href="https://www.facebook.com/CasaToken-136200837022798"><i class="fa fa-facebook"></i></a></span>
				<span><a style="display: inline-block; color:white; font-size: 32px;font-weight: bold; " href="https://www.instagram.com/casatoken/"><i class="fa fa-instagram"></i></a></span>
			 </div>

			 <div id="go-top">
				<a class="smoothscroll" title="Back to Top" href="#top"><i class="icon icon-arrow-up"></i></a>
			 </div>
		</div>
      </div> <!-- end footer-bottom -->
   </footer>
	   @endif


   <div id="preloader">
    	<div id="loader"></div>
   </div>

   <a href="#" id="help-btn" class="help">
	   <i class="fa fa-question" aria-hidden="true"></i>
   </a>

   <!-- Java Script
   ================================================== -->
   <script src="https://code.jquery.com/jquery-3.2.0.min.js"></script>
   <script src="{{ asset('js/plugins.js') }}"></script>
   <script src="{{ asset('js/main.js') }}"></script>
   <script type="text/javascript" src="/js/plugins/intro.js"></script>
   <script>
	   $(function() {
		   $('#logout').click(function(e) {
			   e.preventDefault();
			   $('#logout-form').submit()
		   });
		   $('#help-btn').click(function(e) {
			   e.preventDefault();
			   startIntro();
		   });
	   })
   </script>



   @yield('scripts')

</body>

</html>
