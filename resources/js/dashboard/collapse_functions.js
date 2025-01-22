$(function() {
	//On collapse section we alternate the arrow icon
	$('.card > a[data-bs-toggle="collapse"]').click(function() {
		if($(this).attr('aria-expanded') == "true")
			$(this).find('i.fa-caret-left').removeClass('fa-caret-left').addClass('fa-caret-down');
		else
			$(this).find('i.fa-caret-down').removeClass('fa-caret-down').addClass('fa-caret-left');
	})
})