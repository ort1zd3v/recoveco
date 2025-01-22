<!DOCTYPE html>
<html lang="{{ setLocale(LC_ALL, env('APP_LOCALE')) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{{ config('app.name', 'Blank') }}</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="app-url" content="{{ env('APP_URL') }}">
	
	@include('components.styles')
	@stack('styles')
</head>
<body>
	<!-- Site wrapper -->
	<div class="wrapper">
		<div class="content-wrapper">
			<div class="container-fluid">
				<div class="body">
					<div class="row">
						<div class="col-sm-12 col-12">
							@yield('content')
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
@include('components.scripts')
@stack('scripts')
</html>
