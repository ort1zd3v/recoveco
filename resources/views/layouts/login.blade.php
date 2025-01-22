@extends('layouts.guest')

@section('content')
<div class="row height-100">
	<div class="col-12 col-md-8 offset-md-2">
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<div id="message" class="row  flex-shrink-0 flex-row ">
			<div class="col-12 col-md-4 offset-md-4">
				<div class="message-container"></div>
				@if(session()->has('status'))
					<div class="alert alert-info dismissible">
						<button type="button" class="btn btn-default" data-bs-dismiss="alert" aria-label="Close">
							<i class="mdi mdi-window-close icon-edit font-size-18"></i>
						</button>
						{!! session()->get('status') !!}
					</div>
				@endif
				@include('crud-maker.components.session-alerts')
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-md-4 offset-md-4 login-form">
				<div class="row login-header">
					<div class="col-12 p-4">
						@yield('header')
					</div>
				</div>
				@if($floatingIcon ?? true)
					<div class="row">
						<img class="w-100 bg-white p-3 pb-0" src="images/logo.png" alt="">
					</div>
				@endif
				<div class="row p-4 pt-1 login-body">
					@yield('body')
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-md-4 offset-md-4">
				@yield('footer')
			</div>
		</div>
	</div>
</div>
@endsection