@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<input type="hidden" id="route" value="roles" />
			<div class="card card-info">
				<div class="card-header">
					<div class="row">
						<div class="col-12 card-title">{{ __('roles.permissions') }}</div>
					</div>
				</div>

				{{ Form::open(['id' => 'role-permissions', 'route' => ["roles.savePermissions", $role->id], 'method' => 'POST']) }}
					@include('crud-maker.components.session-alerts')
					<div class="message-container"></div>
					
					<div class="card-body permissionsContainer">
						<input type="hidden" name="role_id" value="{{ $role->id }}">
						<h3>{{ $role->name }}</h3>
						@include("roles.permissions-tabs", compact('permissionModules', 'permissions'))
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-sm-10 col-lg-4 offset-lg-8 text-end">
								<button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
								<a href="{{ route('roles.index') }}">
									<button type="button" class="btn btn-secondary">{{ __('Cancel') }}</button>
								</a>
							</div>
						</div>
					</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>
@endsection