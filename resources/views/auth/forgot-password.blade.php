@extends('layouts.login', ['floatingIcon' => false])

@section('header')
	<h4 class="pb-1">
		@lang('auth.reset_password_title')
	</h4>
@endsection
@section('body')
	@if (session('status'))
	<div class="alert alert-success" role="alert">
		{{ session('status') }}
	</div>
	@endif

	<form method="POST" action="{{ route('password.email') }}">
		@csrf

		<div class="row">
			<div class="col-12">
				<label for="email" class="font-weight-bold">
					@lang('E-Mail Address')
				</label>
			</div>
		</div>
		<div class="row mb-4">
			<div class="col-12">
				<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

				@error('email')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
		</div>

		<div class="row mb-4">
			<div class="col-12 col-md-6">
				<button type="submit" class="btn btn-primary w-100">
					@lang('auth.button_password_reset')
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
