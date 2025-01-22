@extends('layouts.app', [
	'title' => __('sellings.title_show'), 
])

@section('content')
<div class="report-container p-3">
	<div class="row">
		<div class="col-sm-12 col-md-6 offset-md-3">
			<br>
			<div class="card card-info">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-12 col-md-6 card-title">@lang('sellings.title_show')</div>
						<div class="col-sm-12 col-md-6 text-right">
							<a href="{{ route('sellings.index') }}">
								<i class="fas fa-long-arrow-alt-left"></i>
							</a>
						</div>
					</div>
				</div>
				<div class="card-body">
					
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('sellings.id')</div>
						<div class="col-sm-6">{{ $selling->id }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('sellings.client_id')</div>
						<div class="col-sm-6">{{ $selling->client_id }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('sellings.subtotal')</div>
						<div class="col-sm-6">{{ $selling->subtotal }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('sellings.iva')</div>
						<div class="col-sm-6">{{ $selling->iva }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('sellings.total')</div>
						<div class="col-sm-6">{{ $selling->total }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('sellings.notes')</div>
						<div class="col-sm-6">{{ $selling->notes }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('sellings.is_active')</div>
						<div class="col-sm-6">{{ $selling->is_active }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('sellings.created_by')</div>
						<div class="col-sm-6">{{ $selling->created_by }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('sellings.updated_by')</div>
						<div class="col-sm-6">{{ $selling->updated_by }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('sellings.created_at')</div>
						<div class="col-sm-6">{{ $selling->created_at }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('sellings.updated_at')</div>
						<div class="col-sm-6">{{ $selling->updated_at }}</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection