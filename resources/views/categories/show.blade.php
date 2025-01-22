@extends('layouts.app', [
	'title' => __('categories.title_show'), 
])

@section('content')
<div class="report-container p-3">
	<div class="row">
		<div class="col-sm-12 col-md-6 offset-md-3">
			<br>
			<div class="card card-info">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-12 col-md-6 card-title">@lang('categories.title_show')</div>
						<div class="col-sm-12 col-md-6 text-right">
							<a href="{{ route('categories.index') }}">
								<i class="fas fa-long-arrow-alt-left"></i>
							</a>
						</div>
					</div>
				</div>
				<div class="card-body">
					
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('categories.id')</div>
						<div class="col-sm-6">{{ $category->id }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('categories.category_id')</div>
						<div class="col-sm-6">{{ $category->category_id }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('categories.name')</div>
						<div class="col-sm-6">{{ $category->name }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('categories.description')</div>
						<div class="col-sm-6">{{ $category->description }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('categories.notes')</div>
						<div class="col-sm-6">{{ $category->notes }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('categories.is_active')</div>
						<div class="col-sm-6">{{ $category->is_active }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('categories.created_by')</div>
						<div class="col-sm-6">{{ $category->created_by }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('categories.updated_by')</div>
						<div class="col-sm-6">{{ $category->updated_by }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('categories.created_at')</div>
						<div class="col-sm-6">{{ $category->created_at }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('categories.updated_at')</div>
						<div class="col-sm-6">{{ $category->updated_at }}</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection