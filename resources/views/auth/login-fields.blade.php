<div class="col-12 mt-4">
	<div class="alert alert-success d-none" role="alert"></div>
	<form method="POST" action="{{ route('login') }}">
		@csrf
		<div class="row">
			<div class="col">
				<label for="email" class="col-form-label text-lg-right text-secondary">
					@lang('auth.email')
				</label>
			</div>
		</div>
		<div class="row mb-4">
			<div class="col">
				<input id="email" type="email" class="form-control input-login @error('email') is-invalid @enderror input" 
					name="email" required autocomplete="email" placeholder="@lang('E-Mail Address')" value="{{ old('email') }}" autofocus>

				@error('email')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
		</div>

		<div class="row">
			<div class="col">
			<label for="password" class="col-form-label text-md-right text-secondary">
				@lang('auth.password')
			</label>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<input id="password" type="password" class="form-control input-login @error('password') is-invalid @enderror input" 
					name="password" required autocomplete="current-password" placeholder="@lang('Password')">

				@error('password')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
		</div>
		<div class="row">
			<div class="col-12 pt-4">
				<input type="checkbox" name="remember" id="remember">
				<label for="remember">@lang('auth.remember_me')</label>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col-12">
				<button type="submit" class="w-100 btn btn-primary">
					@lang('auth.login_button')
				</button>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col-12 col-md-12 text-center">
				@if (Route::has('password.request'))
					<a class="app-link" href="{{ route('password.request') }}">
						<i class='bx bxs-lock-alt'></i>
						@lang('auth.password_recover')
					</a>
				@endif
			</div>
		</div>
	</form>
</div>