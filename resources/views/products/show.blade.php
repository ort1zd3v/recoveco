@extends('layouts.app', [
	'title' => __('products.title_show'), 
])

@section('content')
<div class="report-container p-3">
	<div class="row">
		<div class="col-sm-12 col-md-6 offset-md-3">
			<br>
			<div class="card card-info">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-12 col-md-6 card-title">@lang('products.title_show')</div>
						<div class="col-sm-12 col-md-6 text-right">
							<a href="{{ route('products.index') }}">
								<i class="fas fa-long-arrow-alt-left"></i>
							</a>
						</div>
					</div>
				</div>
				<div class="card-body">
					
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('products.id')</div>
						<div class="col-sm-6">{{ $product->id }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('products.unit_type_id')</div>
						<div class="col-sm-6">{{ $product->unit_type_id }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('products.category_id')</div>
						<div class="col-sm-6">{{ $product->category_id }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('products.name')</div>
						<div class="col-sm-6">{{ $product->name }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('products.barcode')</div>
						<div class="col-sm-6">{{ $product->barcode }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('products.color')</div>
						<div class="col-sm-6">{{ $product->color }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('products.url_color')</div>
						<div class="col-sm-6">{{ $product->url_color }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('products.print_order')</div>
						<div class="col-sm-6">{{ $product->print_order }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('products.iva')</div>
						<div class="col-sm-6">{{ $product->iva }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('products.cost_base')</div>
						<div class="col-sm-6">{{ $product->cost_base }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('products.cost_min')</div>
						<div class="col-sm-6">{{ $product->cost_min }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('products.cost_max')</div>
						<div class="col-sm-6">{{ $product->cost_max }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('products.price_base')</div>
						<div class="col-sm-6">{{ $product->price_base }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('products.price_min')</div>
						<div class="col-sm-6">{{ $product->price_min }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('products.price_max')</div>
						<div class="col-sm-6">{{ $product->price_max }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('products.is_saleable')</div>
						<div class="col-sm-6">{{ $product->is_saleable }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('products.is_ticketable')</div>
						<div class="col-sm-6">{{ $product->is_ticketable }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('products.is_discountable')</div>
						<div class="col-sm-6">{{ $product->is_discountable }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('products.is_favorite')</div>
						<div class="col-sm-6">{{ $product->is_favorite }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('products.is_consigment')</div>
						<div class="col-sm-6">{{ $product->is_consigment }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('products.is_product')</div>
						<div class="col-sm-6">{{ $product->is_product }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('products.notes')</div>
						<div class="col-sm-6">{{ $product->notes }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('products.is_active')</div>
						<div class="col-sm-6">{{ $product->is_active }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('products.created_by')</div>
						<div class="col-sm-6">{{ $product->created_by }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('products.updated_by')</div>
						<div class="col-sm-6">{{ $product->updated_by }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('products.created_at')</div>
						<div class="col-sm-6">{{ $product->created_at }}</div>
					</div>
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang('products.updated_at')</div>
						<div class="col-sm-6">{{ $product->updated_at }}</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection