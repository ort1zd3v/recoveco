<div class="row" id="container_points">
	<div class="col-6">
		<div class="input-group mt-3" id="container_points">
			<input type="hidden" name="client_id" id="client_id">
			<input type="hidden" name="client_points" id="client_points">
			<input type="hidden" name="min_required" id="min_required" value="{{ $configClients->min_required }}">
			<input type="text" class="form-control input-autocomplete" placeholder="Cliente" id="client_input"
				data-source="clients/getbyparam"
				data-filter="name,client_number"
				data-filter-type="or"
				data-hidden-id="client_id"
				data-aditionals="setClientData">
			<button class="btn btn-danger" type="button" onclick="resetClient(this)">
				<i class="fas fa-times"></i>
			</button>
		</div>
	</div>
	
	<div class="col-6">
		<div class="row mt-4">
			<div class="col-12 selected-client d-none">
				<span class="client-label"></span>
				<span> - </span>
				<span class="client-points"></span>
			</div>
		</div>
	</div>
</div>
