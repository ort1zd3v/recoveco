@extends('layouts.app', [
	'title' => __('ingredients.title_show'), 
])

@section('content')
<div class="report-container p-3">
	<div class="row">
		<div class="col-sm-12 col-md-6 offset-md-3">
			<br>
			<div class="card card-info">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-12 col-md-6 card-title">@lang('ingredients.title_show')</div>
						<div class="col-sm-12 col-md-6 text-right">
							<a href="{{ route('ingredients.index') }}">
								<i class="fas fa-long-arrow-alt-left"></i>
							</a>
						</div>
					</div>
				</div>
				<div class="card-body">
					
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('ingredients.id')</div>
						<div class="col-sm-6">{{ $ingredient->id }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('ingredients.product_id')</div>
						<div class="col-sm-6">{{ $ingredient->product_id }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('ingredients.ingredient_id')</div>
						<div class="col-sm-6">{{ $ingredient->ingredient_id }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('ingredients.category_id')</div>
						<div class="col-sm-6">{{ $ingredient->category_id }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('ingredients.amount')</div>
						<div class="col-sm-6">{{ $ingredient->amount }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('ingredients.notes')</div>
						<div class="col-sm-6">{{ $ingredient->notes }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('ingredients.is_active')</div>
						<div class="col-sm-6">{{ $ingredient->is_active }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('ingredients.created_by')</div>
						<div class="col-sm-6">{{ $ingredient->created_by }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('ingredients.updated_by')</div>
						<div class="col-sm-6">{{ $ingredient->updated_by }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('ingredients.created_at')</div>
						<div class="col-sm-6">{{ $ingredient->created_at }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('ingredients.updated_at')</div>
						<div class="col-sm-6">{{ $ingredient->updated_at }}</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection