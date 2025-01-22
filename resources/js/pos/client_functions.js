$(function() {
	window.setClientData = (data) => {
		$("#container_points #client_points").val(data.points);
		$("#container_points .selected-client").removeClass("d-none");
		$("#container_points .selected-client .client-label").html(data.value);
		$("#container_points .selected-client .client-points").html(data.points);
	}

	window.resetClient = () => {
		$("#container_points #client_id").val("");
		$("#container_points #client_input").val("");
		$("#container_points #client_points").val("");
		$("#container_points .selected-client").addClass("d-none");
		$("#container_points .selected-client .client-label").html("");
		$("#container_points .selected-client .client-points").html("");
	}
});




