<div onclick="deleteSelectedIngredient(this)" class="ingredient" data-toggle="tooltip" data-placement="top" title="{{$ingredient['product_name']}}">
	<span>x</span>
	<img class="img-fluid w-100" src="{{$ingredient['url_image'] == 'no-image.png' ? "/images/no-image.png" : $ingredient['url_image']}}" 
	style="background-color: {{$ingredient['color'] == "" ? "#26a9e1" : $ingredient['color']}}; aspect-ratio: 1/1">
	<input type="hidden" class="id" value="{{$ingredient['id']}}">
	<input type="hidden" class="category_id" value="{{$ingredient['category_id']}}">
	<input type="hidden" class="amount" value="{{$ingredient['amount']}}">
	<input type="hidden" class="product_id" value="{{$ingredient['product_id']}}">
	<input type="hidden" class="product_name" value="{{$ingredient['product_name']}}">
	<input type="hidden" class="overprice" value="{{$ingredient['overprice']}}">
	<input type="hidden" class="pos" value="{{$ingredient['pos']}}">
	<p class="m-0 mt-1 product-text">{{$ingredient['product_name']}}</p>
</div>