<!DOCTYPE html>
<html lang="{{ setLocale(LC_ALL, env('APP_LOCALE')) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{{ (isset($title) ? $title." - " : "").config('app.name') }}</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="app-url" content="{{ config('app.url') }}">
	
	@include('components.styles')
	@stack('styles')
</head>
<body data-sidebar="dark">
	<!-- Site wrapper -->
	<div id="layout-wrapper">
		@include('components.theme.topbar')
		@include('components.theme.sidebar')
		
		<div class="main-content">
			<div class="page-content">
				<div class="container-fluid">
					@yield('content')
				</div>
			</div>
			{{-- @include('components.theme.footer') --}}
		</div>

		@include('components.theme.right-sidebar')
	</div>
</body>
@include('components.scripts')
@stack('scripts')
</html>
