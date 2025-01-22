<div class="modal app-modal" id="registerModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="card">
					<div class="card-header">
						@lang('Register')
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>

					<div class="card-body">
						<form id="registerForm" method="POST" action="{{ route('register') }}">
							@csrf

							<div class="form-group row name-row">
								<label for="name" class="col-md-4 col-form-label text-md-right">
									@lang('Name')
								</label>

								<div class="col-md-6">
									<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

									<span class="invalid-feedback" role="alert"></span>
								</div>
							</div>

							<div class="form-group row email-row">
								<label for="email" class="col-md-4 col-form-label text-md-right">
									@lang('E-Mail Address')
								</label>

								<div class="col-md-6">
									<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

									<span class="invalid-feedback" role="alert"></span>
								</div>
							</div>

							<div class="form-group row password-row">
								<label for="password" class="col-md-4 col-form-label text-md-right">
									@lang('Password')
								</label>

								<div class="col-md-6">
									<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

									<span class="invalid-feedback" role="alert"></span>
								</div>
							</div>

							<div class="form-group row">
								<label for="password-confirm" class="col-md-4 col-form-label text-md-right">
									@lang('Confirm Password')
								</label>

								<div class="col-md-6">
									<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
								</div>
							</div>

							<div class="form-group row mb-0">
								<button type="button" id="registerButton" class="btn button col-md-6 offset-md-3">
									@lang('Register')
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>