@extends('layouts.login', ['floatingIcon' => false])

@section('header')
	<h4 class="pb-1">
		@lang('auth.register_title')
	</h4>
@endsection
@section('body')
	<form method="POST" action="{{ route('register') }}">
		@csrf
		
		@include('auth.register-row', ['name' => 'name', 'type' => 'text'])
		@include('auth.register-row', ['name' => 'paternal_surname', 'type' => 'text'])
		@include('auth.register-row', ['name' => 'maternal_surname', 'type' => 'text'])
		@include('auth.register-row', ['name' => 'email', 'type' => 'email'])
		@include('auth.register-row', ['name' => 'password', 'type' => 'password'])
		@include('auth.register-row', ['name' => 'password_confirmation', 'type' => 'password'])

		<div class="row mb-4">
			<div class="col-12 col-md-6">
				<button type="submit" class="btn btn-primary w-100">
					@lang('auth.button_register')
				</button>
			</div>
			<div class="col-12 col-md-6">
				<a href="{{ route("login") }}">
				<button type="button" class="btn btn-secondary w-100">
					@lang('auth.button_cancel')
				</button>
				</a>
			</div>
		</div>
	</form>
@endsection