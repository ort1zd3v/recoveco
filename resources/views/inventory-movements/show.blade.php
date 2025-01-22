@extends('layouts.app', [
	'title' => __('inventory_movements.title_show'), 
])

@section('content')
<div class="report-container p-3">
	<div class="row">
		<div class="col-sm-12 col-md-6 offset-md-3">
			<br>
			<div class="card card-info">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-12 col-md-6 card-title">@lang('inventory_movements.title_show')</div>
						<div class="col-sm-12 col-md-6 text-right">
							<a href="{{ route('inventory_movements.index') }}">
								<i class="fas fa-long-arrow-alt-left"></i>
							</a>
						</div>
					</div>
				</div>
				<div class="card-body">
					
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('inventory_movements.id')</div>
						<div class="col-sm-6">{{ $inventory_movement->id }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('inventory_movements.product_id')</div>
						<div class="col-sm-6">{{ $inventory_movement->product_id }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('inventory_movements.inventory_movement_type_id')</div>
						<div class="col-sm-6">{{ $inventory_movement->inventory_movement_type_id }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('inventory_movements.amount')</div>
						<div class="col-sm-6">{{ $inventory_movement->amount }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('inventory_movements.notes')</div>
						<div class="col-sm-6">{{ $inventory_movement->notes }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('inventory_movements.is_active')</div>
						<div class="col-sm-6">{{ $inventory_movement->is_active }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('inventory_movements.created_by')</div>
						<div class="col-sm-6">{{ $inventory_movement->created_by }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('inventory_movements.updated_by')</div>
						<div class="col-sm-6">{{ $inventory_movement->updated_by }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('inventory_movements.created_at')</div>
						<div class="col-sm-6">{{ $inventory_movement->created_at }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('inventory_movements.updated_at')</div>
						<div class="col-sm-6">{{ $inventory_movement->updated_at }}</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection