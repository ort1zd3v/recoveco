{{-- Este componente agrega un row a una tabla de agregar multirow --}}
<div class="row table-row mb-4">
	<input type="hidden" name="id">
	@foreach($inputs as $input)
		<div class="col-12 col-sm-{{ $input["cols"] }}">
			@include('crud-maker.components.field-add', ["params" => $input["params"]])
			<div class="d-inline validation-error {{ $input["params"]["field"] }}-error text-danger"></div>
		</div>
	@endforeach
	<div class="col-12 col-sm">
		{{-- <button type='button' class='btn btn-save' onclick="saveRow(this)">
			<i class='fas fa-save'></i>
		</button>
		<button type='button' class='btn text-danger btn-unsaved d-none'>
			<i class='fas fa-exclamation'></i>
		</button>
		<button type='button' class='btn text-success btn-saved d-none'>
			<i class='fas fa-check'></i>
		</button> --}}
		<button type='button' class='btn text-danger btn-delete' onclick="deleteRow(this)">
			<i class='fa fa-times actions_icon'></i>
		</button>
	</div>
</div>