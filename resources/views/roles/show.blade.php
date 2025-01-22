@extends('layouts.app')

@section('content')
<div class="report-container p-3">
	<div class="row">
		<div class="col-sm-12 col-md-6 offset-md-3">
			<br>
			<div class="card card-info">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-12 col-md-6 card-title">{{ __('roles.title_show') }}</div>
						<div class="col-sm-12 col-md-6 text-end">
							<a href="{{ route('roles.index') }}">
								<i class="fas fa-long-arrow-alt-left"></i>
							</a>
						</div>
					</div>
				</div>
				<div class="card-body">
					
					<div class="form-group">
						<div class="row">
							<div class="col-sm-4 offset-sm-1 text-end">{{ __('roles.id') }}</div>
							<div class="col-sm-6">{{ $role->id }}</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-4 offset-sm-1 text-end">{{ __('roles.name') }}</div>
							<div class="col-sm-6">{{ $role->name }}</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-4 offset-sm-1 text-end">{{ __('roles.description') }}</div>
							<div class="col-sm-6">{{ $role->description }}</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-4 offset-sm-1 text-end">{{ __('roles.created_at') }}</div>
							<div class="col-sm-6">{{ $role->created_at }}</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-4 offset-sm-1 text-end">{{ __('roles.updated_at') }}</div>
							<div class="col-sm-6">{{ $role->updated_at }}</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection