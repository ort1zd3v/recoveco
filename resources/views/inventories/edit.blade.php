@extends('layouts.app', [
	'title' => __('inventories.title_edit'), 
])

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<div class="card card-info">
				<div class="card-header">
					<div class="row">
						<div class="col-12 card-title">@lang('inventories.title_edit')</div>
					</div>
				</div>

				{{ Form::open(['id' => 'inventory-edit', 'route' => ['inventories.update', $inventory->id], 'method' => 'POST']) }}
					@method('PUT')
					@include('crud-maker.components.session-alerts')
					<div class="message-container"></div>
					<div class="card-body">
						@include("inventories.fields", ["isEdit" => true])
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-sm-10 col-lg-4 offset-lg-8 text-end">
								<button type="submit" class="btn btn-primary">@lang('Save')</button>
								<a href="{{ route('inventories.index') }}">
									<button type="button" class="btn btn-secondary">@lang('Cancel')</button>
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