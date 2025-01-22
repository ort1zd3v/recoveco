@php
	$disabled = $productId == 0 ? true : false;
@endphp
<div class="container-fluid" id="container-ingredients">
	<div class="row">
		<div class="col-12">
			<div class="card card-info">
				<div class="card-header">
					<div class="row">
						{{-- <div class="col-12 card-title">@lang('products.title_edit')</div> --}}
					</div>
				</div>

				{{ Form::open(['id' => 'ingredient-create', 'route' => ['ingredients.create'], 'method' => 'POST']) }}
					<div class="message-container"></div>
					<div class="card-body">
						<h3>Ingredientes</h3>
						<hr>
						<div class="row">
							<div class="col-12 col-md-4">
								<input 
									type="hidden" 
									id="product_id" 
									name="product_id" 
									value="{{$productId == 0 ? '' : $productId}}">
									
								@include("crud-maker.components.form-row", ["params" => [
									[
										"name" => "amount",
										"id" => "amount",
										"class" => "form-control ingredient-field",
										"entity" => "products",
										"type" => "number",
										"defaultValue" => old("amount") ?? "",
										"required" => "true",
										"disabled" => $disabled
									]
								]])

								@include('crud-maker.components.form-row', [
									'params' => [
										[
											'name' => 'category_input',
											'id' => 'category_input',
											'class' => 'form-control input-autocomplete ingredient-field',
											'entity' => 'products',
											"translations" => "products.category_id",
											'type' => 'input-autocomplete',
											'defaultValue' => old("category_input"),
											"required" => "true",
											"data-source" => "categories/getbyparam",
											"data-hidden-id" => "category_id",
											"data-hidden-value" => old("category_id"),
											"data-filter" => "name",
											"child" => "ingredient_input",
											"child-hidden" => "ingredient_id",
											"disabled" => $disabled
										],
									],
								])

								@include('crud-maker.components.form-row', [
									'params' => [
										[
											'name' => 'ingredient_input',
											'id' => 'ingredient_input',
											'class' => 'form-control input-autocomplete ingredient-field',
											'entity' => 'products',
											"translations" => "products.product",
											'type' => 'input-autocomplete',
											'defaultValue' => old("ingredient_input"),
											"data-source" => "products/getbyparam/0",
											"data-hidden-id" => "ingredient_id",
											"data-hidden-value" => old("ingredient_id"),
											"data-filter" => "name",
											"disabled" => $disabled
										],
									],
								])
								<div class="row">
									<div class="col-12 text-end">
										<button 
											type="submit" 
											class="btn btn-primary ingredient-field" 
											@disabled($disabled)>
											@lang('Save')
										</button>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-8">
								{{ $dataTable->html()->table() }}
							</div>
						</div>
					</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>
@push('scripts')
    {{ $dataTable->html()->scripts(attributes: ['type' => 'module']) }}
	<script src="{{asset('js/products/ingredient.js')}}"></script>
@endpush