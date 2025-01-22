<h1>Datatables y botones</h1>
<div class="row">
	<div class="col-lg-5 card p-3 border">
		<div class="row">
			<p class="font-size-18"><b>Header</b></p>
			<hr>
			<div class="row">
				<div class="col">
					<div class="mt-2">
						<p class="mb-2">Color fondo</p>
						@php
							$rgb = explode(",", $template->datatables_header_backround_color);
							$r = intval($rgb[0]);
							$g = intval($rgb[1]);
							$b = intval($rgb[2]);
						@endphp
						<input name="data[datatables_header_backround_color]" id="datatableHeaderBackgroundColor" type="color" class="form-control" value="{{ sprintf("#%02x%02x%02x", $r, $g, $b) ?? "#ffffff"}}">
					</div>
				</div>
				<div class="col">
					<div class="mt-2">
						<p class="mb-2">Color de fuente</p>
						<input name="data[datatables_header_font_color]" id="datatableHeaderColor" type="color" class="form-control" value="{{$template->datatables_header_font_color ?? "#ffffff"}}">
					</div>
				</div>
			</div>
		</div>

		<div class="row mt-3">
			<p class="font-size-18"><b>Botón agregar</b></p>
			<hr>
			<div class="row">
				<div class="col">
					<div class="mt-2">
						<p class="mb-2">Color fondo</p>
						<input name="data[datatables_add_background_color]" id="datatableAddBackgroundColor" type="color" class="form-control" value="{{$template->datatables_add_background_color ?? "#ffffff"}}">
					</div>
				</div>
				<div class="col">
					<div class="mt-2">
						<p class="mb-2">Color de fuente</p>
						<input name="data[datatables_add_font_color]" id="datatableAddColor" type="color" class="form-control" value="{{$template->datatables_add_font_color ?? "#ffffff"}}">
					</div>
				</div>
			</div>
		</div>

		<div class="row mt-3">
			<p class="font-size-18"><b>Botón editar</b></p>
			<hr>
			<div class="row">
				<div class="col">
					<div class="mt-2">
						<p class="mb-2">Color de fuente</p>
						<input name="data[datatables_edit_font_color]" id="datatableEditColor" type="color" class="form-control" value="{{$template->datatables_edit_font_color ?? "#ffffff"}}">
					</div>
				</div>
			</div>
		</div>

		<div class="row mt-3">
			<p class="font-size-18"><b>Botón eliminar</b></p>
			<hr>
			<div class="row">
				<div class="col">
					<div class="mt-2">
						<p class="mb-2">Color de fuente</p>
						<input name="data[datatables_delete_font_color]" id="datatableDeleteColor" type="color" class="form-control" value="{{$template->datatables_delete_font_color ?? "#ffffff"}}">
					</div>
				</div>
			</div>
		</div>

		<div class="d-flex gap-2 mt-3 justify-content-end">
			<button type="submit" class="btn btn-primary">Guardar</button>
		</div>
	</div>
</div>