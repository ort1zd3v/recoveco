@push('styles')
	<link rel="stylesheet" href="{{asset('css/owl-carousel/owl.carousel.min.css')}}">
	<link rel="stylesheet" href="{{asset('css/owl-carousel/owl.theme.default.min.css')}}">
@endpush

@include("products.fields.general-fields")

@include("products.fields.cost-fields")

@include("products.fields.price-fields")

@include("products.fields.additional-fields")


@push('scripts')
	{{-- <script src="{{asset('js/owl-carousel/owl.carousel.min.js')}}"></script>
	<script>
		$(document).ready(function(){
			$('.owl-carousel').owlCarousel({
				items: 1,
				margin:10,
				nav:true,
				responsiveClass:true,
			});
		});
	</script> --}}

	<script>
		$(document).ready(function(){
			const background_color =  $("#color").val();
			$("#image_product").stop().animate({backgroundColor: background_color}, 300);
			$("#url_image").change(function(){
				var TmpPath = URL.createObjectURL($('#url_image').prop('files')[0]);
				$('#image_product').attr('src', TmpPath);
				const background_color =  $("#color").val();
				$("#image_product").stop().animate({backgroundColor: background_color}, 300);
			})
			$("#color").change(function(){
				const background_color =  $("#color").val();
				$("#image_product").stop().animate({backgroundColor: background_color}, 300);
			});


			$("#saveBtn").click(function(e) {
				if ($("#is_consigment").is(':checked')) {
					if ($('#supplier_id').val() == '') {
						showAlert('Falta recovequero', 'Seleccione el recovequero.');
						e.preventDefault()
					}
				}
			})
		});
	</script>
@endpush