@extends('layouts.login', ['floatingIcon' => false])

@section('header')
	<h4 class="pb-1">
		@lang('auth.reset_password_title')
	</h4>
@endsection
@section('body')
	<form method="POST" action="{{ route('password.update') }}">
		@csrf

		<input type="hidden" name="token" value="{{ $request->route('token') }}">
		
		@include('auth.register-row', ['name' => 'email', 'type' => 'email'])
		@include('auth.register-row', ['name' => 'password', 'type' => 'password'])
		@include('auth.register-row', ['name' => 'password_confirmation', 'type' => 'password'])
		
		<div class="row">
			<div class="col-12">
				<button type="submit" class="btn btn-primary w-100">
					@lang('auth.button_reset_password')
				</button>
			</div>
		</div>
	</form>
@endsection
