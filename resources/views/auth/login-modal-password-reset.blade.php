<div class="modal app-modal" id="passwordResetModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="card">
					<div class="card-header">
						@lang('Reset Password')
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>

					<div class="card-body">
						<form id="passwordResetForm" method="POST" action="{{ route('password.email') }}">
							@csrf

							<div class="form-group row email-row">
								<label for="email" class="col-md-4 col-form-label text-md-right">
									@lang('E-Mail Address')
								</label>

								<div class="col-md-6">
									<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

									
									<span class="invalid-feedback" role="alert"></span>
								</div>
							</div>

							<div class="form-group row mb-0">
								<button type="button" id="passwordResetButton" class="btn button col-md-6 offset-md-3">
									@lang('Send Password Reset Link')
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>