<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-GF11LFKH80"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
        
          gtag('config', 'G-GF11LFKH80');
        </script>
        @include('backend.layouts.head')
    </head>

	<body class="main-body app sidebar-mini">
		<!-- Loader -->
		<div id="global-loader">
			<img src="{{URL::asset('assets/img/loader.svg')}}" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->
		@include('backend.layouts.main-sidebar')
		<!-- main-content -->
		<div class="main-content app-content">
			@include('backend.layouts.main-header')
			<!-- container -->
			<div class="container-fluid">
				@yield('page-header')
				@yield('content')
				@include('backend.layouts.sidebar')
				@include('backend.layouts.models')
            	@include('backend.layouts.footer')
				@include('backend.layouts.footer-scripts')


            </body>
</html>
