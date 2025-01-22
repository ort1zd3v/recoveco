@extends('layouts.app', [
	'title' => __('clients.title_show'), 
])

@section('content')
<div class="report-container p-3">
	<div class="row">
		<div class="col-sm-12 col-md-6 offset-md-3">
			<br>
			<div class="card card-info">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-12 col-md-6 card-title">@lang('clients.title_show')</div>
						<div class="col-sm-12 col-md-6 text-right">
							<a href="{{ route('clients.index') }}">
								<i class="fas fa-long-arrow-alt-left"></i>
							</a>
						</div>
					</div>
				</div>
				<div class="card-body">
					
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('clients.id')</div>
						<div class="col-sm-6">{{ $client->id }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('clients.name')</div>
						<div class="col-sm-6">{{ $client->name }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('clients.client_number')</div>
						<div class="col-sm-6">{{ $client->client_number }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('clients.branch_id')</div>
						<div class="col-sm-6">{{ $client->branch_id }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('clients.notes')</div>
						<div class="col-sm-6">{{ $client->notes }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('clients.is_active')</div>
						<div class="col-sm-6">{{ $client->is_active }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('clients.created_by')</div>
						<div class="col-sm-6">{{ $client->created_by }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('clients.updated_by')</div>
						<div class="col-sm-6">{{ $client->updated_by }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('clients.created_at')</div>
						<div class="col-sm-6">{{ $client->created_at }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('clients.updated_at')</div>
						<div class="col-sm-6">{{ $client->updated_at }}</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection