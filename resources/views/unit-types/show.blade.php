@extends('layouts.app', [
	'title' => __('unit_types.title_show'), 
])

@section('content')
<div class="report-container p-3">
	<div class="row">
		<div class="col-sm-12 col-md-6 offset-md-3">
			<br>
			<div class="card card-info">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-12 col-md-6 card-title">@lang('unit_types.title_show')</div>
						<div class="col-sm-12 col-md-6 text-right">
							<a href="{{ route('unit_types.index') }}">
								<i class="fas fa-long-arrow-alt-left"></i>
							</a>
						</div>
					</div>
				</div>
				<div class="card-body">
					
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('unit_types.id')</div>
						<div class="col-sm-6">{{ $unit_type->id }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('unit_types.name')</div>
						<div class="col-sm-6">{{ $unit_type->name }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('unit_types.description')</div>
						<div class="col-sm-6">{{ $unit_type->description }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('unit_types.notes')</div>
						<div class="col-sm-6">{{ $unit_type->notes }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('unit_types.is_active')</div>
						<div class="col-sm-6">{{ $unit_type->is_active }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('unit_types.created_by')</div>
						<div class="col-sm-6">{{ $unit_type->created_by }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('unit_types.updated_by')</div>
						<div class="col-sm-6">{{ $unit_type->updated_by }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('unit_types.created_at')</div>
						<div class="col-sm-6">{{ $unit_type->created_at }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('unit_types.updated_at')</div>
						<div class="col-sm-6">{{ $unit_type->updated_at }}</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection