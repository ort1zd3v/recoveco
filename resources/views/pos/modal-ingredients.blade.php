<div class="modal ingredients-modal" id="ingredients-modal-{{ $product->id }}" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-xl mt-0 mb-0" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">
					@lang('pos.modal-ingredients-title')
				</h5>
				{{-- <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><i class="mdi mdi-window-close icon-edit font-size-18"></i></span>
				</button> --}}
			</div>
			<div class="modal-body">
				{{-- Tabs --}}
				<input type="hidden" id="product_unique_id" value="{{ $uniqueId ?? false }}">
				<input type="hidden" id="button_edit_id" value="{{ $buttonId ?? false }}">

				<div class="ingredients-content font-size-18">
					<ul class="nav nav-tabs d-none" id="myTab" role="tablist">
						@php $active = true; @endphp
						@foreach ($tabs as $key => $tab)
							@include('pos.ingredients-tab-header', compact('tab', 'active'))
							@php $active = false; @endphp
						@endforeach
					</ul>
					<div class="current-product p-3" style="background-color: {{$template->general_menu_background_color}}; color: {{$template->datatables_header_font_color}}">
						<input type="hidden" id="product_id" value="{{ $product->id }}">
						<input type="hidden" id="product_name" value="{{ $product->name }}">
						<input type="hidden" id="product_amount" value="{{$amount}}">

						<input type="hidden" id="product_ingredients" value="{{ $product->getIngredientsAmount() }}">
						<div class="d-flex gap-2 align-items-center">
							<h4 class="m-0" style="color: {{$template->datatables_header_font_color}}">{{ $product->name }} - </h4>
							<h4 class="m-0 d-inline">@lang('pos.remaining_ingredients'):</h4> 
							<strong class="r-ingredients font-size-24">{{  $product->getIngredientsAmount() - (isset($totalIngredients) ? $totalIngredients : 0) }}</strong>
						</div>
					</div>
					
					<div class="ingredients-selected d-flex justify-content-between">
						<div class="w-100 tab-ingredients active p-1" data-tab="Abajo-tab" style="height: 140px; cursor: pointer;" onclick="selectTab('Abajo-tab')"> 
							<a href="#">Abajo</a>
 							<div class="abajo d-flex">
							</div>
							@if (isset($selectedIngredients['bottom']))
								@foreach ($selectedIngredients['bottom'] as $ingredient)
									@include('pos.ingredient', $ingredient)
								@endforeach
							@endif
						</div>
						<div class="w-100 tab-ingredients p-1" data-tab="En-medio-tab" style="height: 140px; cursor: pointer" onclick="selectTab('En-medio-tab')">
							<a href="#">En medio</a>
							<div class="enmedio d-flex">
							</div>
							@if (isset($selectedIngredients['middle']))
								@foreach ($selectedIngredients['middle'] as $ingredient)
									@include('pos.ingredient', $ingredient)
								@endforeach
							@endif
						</div>
						<div class="w-100 tab-ingredients p-1" data-tab="Arriba-tab" style="height: 140px; cursor: pointer" onclick="selectTab('Arriba-tab')">
							<a href="#">Arriba</a>
							<div class="arriba d-flex">
							</div>
							@if (isset($selectedIngredients['top']))
								@foreach ($selectedIngredients['top'] as $ingredient)
									@include('pos.ingredient', $ingredient)
								@endforeach
							@endif
						</div>
					</div>
					<hr class="m-0">
					
					{{-- Tab content --}}
					<div class="tab-content">
						@php 
							$active = true; 
						 	$selected = false; 
						 	$counter = 0; 
						@endphp
						@foreach ($ingredients as $key => $ingredient)
							@if ($ingredient->ingredient_id == null)
								@if (isset($totalIngredients))
									@if ($product->getIngredientsAmount() - $totalIngredients == 0)
										@php 
											$active = false;
											$selected = true; 
										@endphp
									@elseif ($counter == $totalIngredients)
										@php 
											$active = true;
											$selected = false; 
										@endphp
									@elseif($counter>$totalIngredients)
										@php 
											$active = false; 
											$selected = false; 
										@endphp
									@else
										@php 
											$active = false;
											$selected = false; 
										@endphp
									@endif
									@php $counter+=1; @endphp
								@endif
								@include('pos.ingredients-tab-content', [
									"ingredient" => $ingredient, 
									"products" => $ingredient->cat_ingredients->chunk(12),
									"data" => compact('configProducts', 'template'),
									"isGrid" => true,
								])
								@if (!isset($totalIngredients)) 
									@php 
										$active = false; 
										$selected = false; 
									@endphp
								@endif
							@endif
							@php $active = false; @endphp
						@endforeach
					</div>
				</div>
			</div>
			@if($footer ?? true)
				<div class="modal-footer d-block">
					<div class="row">
						<div class="col-3">
							{{ Form::button(__("Cancel"), [
								"class" => "w-100 btn btn-danger p-3 font-size-18", 
								"data-bs-dismiss" => "modal"
							]) }}
						</div>
						<div class="col-3">
							{{ Form::button(__("pos.restart"), [
								"class" => "w-100 btn btn-danger p-3 font-size-18", 
								"onclick" => "resetIngredients(this)"
							]) }}
						</div>
						<div class="col-3">
							{{ Form::button(__("pos.next_product"), [
								"class" => "w-100 btn btn-primary p-3 font-size-18", 
								"onclick" => "showNextProductModal(this)"
							]) }}
						</div>
						<div class="col-3">
							{{ Form::button(__("pos.finish"), [
								"class" => "w-100 btn btn-primary p-3 font-size-18", 
								"onclick" => "addPackToSale(this)"
							]) }}
						</div>
					</div>
				</div>
			@endif
		</div>
	</div>
</div>