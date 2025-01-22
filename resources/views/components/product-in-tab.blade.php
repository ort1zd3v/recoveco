<div style="background-color: {{$template->general_menu_background_color}}; color: {{$template->general_menu_font_color}}; cursor: pointer" class="p-2 text-center rounded product" onclick="selectProduct('{{base64_encode($product)}}', $('#amount').val())">
	@if($configProducts->type_box == "both")
		<img class="img-fluid w-50" src="{{$product->url_image}}">
		<p class="m-1 font-size-16">{{$product->name}}</p>
		<input type="hidden" value="{{$product->barcode}}">
	@elseif ($configProducts->type_box == "icons") 
		<img class="img-fluid w-50" src="{{$product->url_image}}">
		<p class="m-1 font-size-16 d-none">{{$product->name}}</p>
		<input type="hidden" value="{{$product->barcode}}">
	@else
		<p class="m-1 font-size-16">{{$product->name}}</p>
		<input type="hidden" value="{{$product->barcode}}">
	@endif
</div>