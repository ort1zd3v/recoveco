@if ($cols != 0)
	<div style="width: calc({{100/$cols}}% - 1%); {{!$displayImage ? 'height: 120px' : ''}}" class="p-1 d-inline-block p-grid-{{ $product->id }} product">
@else
	<div style="{{!$displayImage ? 'height: 120px' : ''}}" class="p-1 d-inline-block p-grid-{{ $product->id }} product">
@endif
	<div data-tooltip="{{$product->name}}" style="background-color: {{ $template->general_menu_background_color }};
		color: {{ $template->general_menu_font_color }}; cursor: pointer; position: relative;" 
		class="p-2 text-center rounded h-100" 
		onclick="{{ $onclick }}">
		@if ($displayImage ?? true)
			@php
				$img = asset('images/no-image.png');
				if (File::exists(public_path()."/".$product->url_image)) {
					$img = asset($product->url_image);
				}
			@endphp
			<img class="img-fluid" style="width: 100%; aspect-ratio: 1/1; background-color: {{$product->color}}" 
				src="{{ $img }}">		
		@endif
		
		@if (!$displayImage ?? true)
			<p class="position-absolute m-0 mt-1 font-size-16 {{ $displayName ?? true ? '' : 'd-none' }}" style="width: 88%;">
				{{$product->display_name ?? $product->name}}
			</p>
		@else
			<p class="product-text m-0 mt-1 font-size-12 {{ $displayName ?? true ? '' : 'd-none' }}">
				{{$product->display_name ?? $product->name}}
			</p>
		@endif
		
	</div>
</div>