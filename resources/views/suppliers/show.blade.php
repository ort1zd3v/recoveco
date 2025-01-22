@extends('layouts.app', [
	'title' => __('suppliers.title_show'), 
])

@section('content')
<div class="report-container p-3">
	<div class="row">
		<div class="col-sm-12 col-md-6 offset-md-3">
			<br>
			<div class="card card-info">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-12 col-md-6 card-title">@lang('suppliers.title_show')</div>
						<div class="col-sm-12 col-md-6 text-right">
							<a href="{{ route('suppliers.index') }}">
								<i class="fas fa-long-arrow-alt-left"></i>
							</a>
						</div>
					</div>
				</div>
				<div class="card-body">
					
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('suppliers.id')</div>
						<div class="col-sm-6">{{ $supplier->id }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('suppliers.name')</div>
						<div class="col-sm-6">{{ $supplier->name }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('suppliers.description')</div>
						<div class="col-sm-6">{{ $supplier->description }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('suppliers.notes')</div>
						<div class="col-sm-6">{{ $supplier->notes }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('suppliers.is_active')</div>
						<div class="col-sm-6">{{ $supplier->is_active }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('suppliers.created_by')</div>
						<div class="col-sm-6">{{ $supplier->created_by }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('suppliers.updated_by')</div>
						<div class="col-sm-6">{{ $supplier->updated_by }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('suppliers.created_at')</div>
						<div class="col-sm-6">{{ $supplier->created_at }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('suppliers.updated_at')</div>
						<div class="col-sm-6">{{ $supplier->updated_at }}</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection