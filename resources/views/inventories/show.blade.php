@extends('layouts.app', [
	'title' => __('inventories.title_show'), 
])

@section('content')
<div class="report-container p-3">
	<div class="row">
		<div class="col-sm-12 col-md-6 offset-md-3">
			<br>
			<div class="card card-info">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-12 col-md-6 card-title">@lang('inventories.title_show')</div>
						<div class="col-sm-12 col-md-6 text-right">
							<a href="{{ route('inventories.index') }}">
								<i class="fas fa-long-arrow-alt-left"></i>
							</a>
						</div>
					</div>
				</div>
				<div class="card-body">
					
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('inventories.id')</div>
						<div class="col-sm-6">{{ $inventory->id }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('inventories.product_id')</div>
						<div class="col-sm-6">{{ $inventory->product_id }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('inventories.amount')</div>
						<div class="col-sm-6">{{ $inventory->amount }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('inventories.notes')</div>
						<div class="col-sm-6">{{ $inventory->notes }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('inventories.is_active')</div>
						<div class="col-sm-6">{{ $inventory->is_active }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('inventories.created_by')</div>
						<div class="col-sm-6">{{ $inventory->created_by }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('inventories.updated_by')</div>
						<div class="col-sm-6">{{ $inventory->updated_by }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('inventories.created_at')</div>
						<div class="col-sm-6">{{ $inventory->created_at }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('inventories.updated_at')</div>
						<div class="col-sm-6">{{ $inventory->updated_at }}</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection