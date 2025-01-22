@extends('layouts.app')

@section('content')
<div class="report-container p-3">
	<div class="row">
		<div class="col-sm-12 col-md-6 offset-md-3">
			<br>
			<div class="card card-info">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-12 col-md-6 card-title">{{ __('users.title_show') }}</div>
						<div class="col-sm-12 col-md-6 text-end">
							<a href="{{ route('users.index') }}">
								<i class="fas fa-long-arrow-alt-left"></i>
							</a>
						</div>
					</div>
				</div>
				<div class="card-body">
					
					<div class="form-group">
						<div class="row">
							<div class="col-sm-4 offset-sm-1 text-end">{{ __('users.id') }}</div>
							<div class="col-sm-6">{{ $user->id }}</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-4 offset-sm-1 text-end">{{ __('users.role_id') }}</div>
							<div class="col-sm-6">{{ $user->role_id }}</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-4 offset-sm-1 text-end">{{ __('users.name') }}</div>
							<div class="col-sm-6">{{ $user->name }}</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-4 offset-sm-1 text-end">{{ __('users.paternal_surname') }}</div>
							<div class="col-sm-6">{{ $user->paternal_surname }}</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-4 offset-sm-1 text-end">{{ __('users.maternal_surname') }}</div>
							<div class="col-sm-6">{{ $user->maternal_surname }}</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-4 offset-sm-1 text-end">{{ __('users.picture') }}</div>
							<div class="col-sm-6">{{ $user->picture }}</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-4 offset-sm-1 text-end">{{ __('users.email') }}</div>
							<div class="col-sm-6">{{ $user->email }}</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-4 offset-sm-1 text-end">{{ __('users.email_verified_at') }}</div>
							<div class="col-sm-6">{{ $user->email_verified_at }}</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-4 offset-sm-1 text-end">{{ __('users.password') }}</div>
							<div class="col-sm-6">{{ $user->password }}</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-4 offset-sm-1 text-end">{{ __('users.remember_token') }}</div>
							<div class="col-sm-6">{{ $user->remember_token }}</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-4 offset-sm-1 text-end">{{ __('users.created_at') }}</div>
							<div class="col-sm-6">{{ $user->created_at }}</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-4 offset-sm-1 text-end">{{ __('users.updated_at') }}</div>
							<div class="col-sm-6">{{ $user->updated_at }}</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection