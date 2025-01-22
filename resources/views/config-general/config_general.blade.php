<h1>@lang('config_general.general')</h1>
<div class="row">
	<div class="col-lg-5 card p-3 border">
		<div class="row">
			<p class="font-size-18"><b>@lang('config_general.header')</b></p>
			<hr>
			<div class="mt-2">
				<p class="mb-2">@lang('config_general.logo')</p>
				<input name="data[logo]" id="logoFile" type="file" class="form-control" accept="image/*">
			</div>
			<div class="row">
				<div class="col">
					<div class="mt-2">
						<p class="mb-2">@lang('config_general.background_color')</p>
						<input name="data[general_header_background_color]" id="headerBackgroundColor" type="color" class="form-control" value="{{$template->general_header_background_color ?? "#ffffff"}}">
					</div>
				</div>
				<div class="col">
					<div class="mt-2">
						<p class="mb-2">@lang('config_general.font_color')</p>
						<input name="data[general_header_font_color]" id="headerColor" type="color" class="form-control" value="{{$template->general_header_font_color ?? "#ffffff"}}">
					</div>
				</div>
			</div>
			<div class="mt-2">
				@include("crud-maker.components.form-row", ["params" => [
					[
						"name" => "data[general_header_font_id]",
						"id" => "general_header_font_id",
						"class" => "form-select",
						"entity" => "config_general",
						"type" => "select",
						"defaultValue" => old("font_id") ?? ($template->general_header_font_id ?? ""),
						"required" => "true",
						"elements" => $fonts ?? [],
					]
				]])
		</div>
	</div>

	<div class="row mt-3">
		<p class="font-size-18"><b>@lang('config_general.menu')</b></p>
		<hr>
		<div class="mt-2">
			<p class="mb-2">@lang('config_general.position')</p>
			<select name="data[general_menu_position]" id="" class="form-control">
				<option value="left">@lang('config_general.left')</option>
				<option value="top">@lang('config_general.top')</option>
			</select>
		</div>
		<div class="row">
			<div class="col">
				<div class="mt-2">
					<p class="mb-2">@lang('config_general.background_color')</p>
					<input name="data[general_menu_background_color]" id="menuBackgroundColor" type="color" class="form-control" value="{{$template->general_menu_background_color ?? "#ffffff"}}">
				</div>
			</div>
			<div class="col">
				<div class="mt-2">
					<p class="mb-2">@lang('config_general.font_color')</p>
					<input name="data[general_menu_font_color]" id="menuColor" type="color" class="form-control" value="{{$template->general_menu_font_color ?? "#ffffff"}}">
				</div>
			</div>
			<div class="col">
				<div class="mt-2">
					<p class="mb-2">@lang('config_general.font_hover_color')</p>
					<input name="data[general_menu_font_hover_color]" id="menuHoverColor" type="color" class="form-control" value="{{$template->general_menu_font_hover_color ?? "#ffffff"}}">
				</div>
			</div>
		</div>
		<div class="mt-2">
			@include("crud-maker.components.form-row", ["params" => [
				[
					"name" => "data[general_menu_font_id]",
					"id" => "general_menu_font_id",
					"class" => "form-select",
					"entity" => "config_general",
					"type" => "select",
					"defaultValue" => old("font_id") ?? ($template->general_menu_font_id ?? ""),
					"required" => "true",
					"elements" => $fonts ?? [],
				]
			]])
		</div>
		<div class="mt-2">
			<input name="data[general_menu_icons]" class="form-check-input" type="checkbox" id="iconsCheck" {{$template->general_menu_icons == "on" ? "checked" : ""}}>
			<label class="form-check-label" for="iconsCheck">@lang('config_general.show_menu_icons')</label>
		</div>
	</div>


	<div class="row mt-3">
		<p class="font-size-18"><b>@lang('config_general.body')</b></p>
		<hr>
		<div class="row">
			<div class="col">
				<div class="mt-2">
					<p class="mb-2">@lang('config_general.background_color')</p>
					<input name="data[general_body_background_color]" id="contentBackgroundColor" type="color" class="form-control" value="{{$template->general_body_background_color ?? "#ffffff"}}">
				</div>
			</div>
			<div class="col">
				<div class="mt-2">
					<p class="mb-2">@lang('config_general.font_color')</p>
					<input name="data[general_body_font_color]" id="contentColor" type="color" class="form-control" value="{{$template->general_body_font_color ?? "#ffffff"}}">
				</div>
			</div>
		</div>
		<div class="mt-2">
			@include("crud-maker.components.form-row", ["params" => [
				[
					"name" => "data[general_body_font_id]",
					"id" => "general_body_font_id",
					"class" => "form-select",
					"entity" => "config_general",
					"type" => "select",
					"defaultValue" => old("font_id") ?? ($template->general_body_font_id ?? ""),
					"required" => "true",
					"elements" => $fonts ?? [],
				]
			]])
		</div>
	</div>


	<div class="row mt-3">
		<p class="font-size-18"><b>@lang('config_general.footer')</b></p>
		<hr>
		<div class="row">
			<div class="col">
				<div class="mt-2">
					<p class="mb-2">@lang('config_general.background_color')</p>
					<input name="data[general_footer_background_color]" id="footerBackgroundColor" type="color" class="form-control" value="{{$template->general_footer_background_color ?? "#ffffff"}}">
				</div>
			</div>
			<div class="col">
				<div class="mt-2">
					<p class="mb-2">@lang('config_general.font_color')</p>
					<input name="data[general_footer_font_color]" id="footerColor" type="color" class="form-control" value="{{$template->general_footer_font_color ?? "#ffffff"}}">
				</div>
			</div>
		</div>
		<div class="mt-2">
			@include("crud-maker.components.form-row", ["params" => [
				[
					"name" => "data[general_footer_font_id]",
					"id" => "general_footer_font_id",
					"class" => "form-select",
					"entity" => "config_general",
					"type" => "select",
					"defaultValue" => old("font_id") ?? ($template->general_footer_font_id ?? ""),
					"required" => "true",
					"elements" => $fonts ?? [],
				]
			]])
		</div>
	</div>
	<div class="d-flex gap-2 mt-3 justify-content-end">
		<button type="submit" class="btn btn-primary">Guardar</button>
	</div>
</div>