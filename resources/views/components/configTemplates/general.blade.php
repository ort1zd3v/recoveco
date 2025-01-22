<style>
	.menu-item:hover {
		cursor: pointer;
		color: {{$template->general_menu_font_hover_color}}
	}
</style>
<div class="col-lg-7 d-flex align-items-center justify-content-center">
	<div class="previewConfiguration" >
		<div class="row m-0">
			<div class="col-4 p-0">
				<div id="menu" style="background-color: {{$template->general_menu_background_color ?? "#fff"}}; color: {{$template->general_menu_font_color ?? "#fff"}}; font-family: {{$template->general_menu_font ?? "Arial"}}; height: 420px">
					<div class="d-flex justify-content-center p-2">
						<img src="{{$template->logo}}" id="logoPreview" width="50%">
					</div>
					<div class="menu-item d-flex aling-items-center p-2 gap-1">
						<i class='bx bxs-user-circle font-size-18 icon' style="display: {{$template->general_menu_icons == "off" ? "none" : "block"}}"></i>
						<span>Menú item</span>
					</div>
					<div class="menu-item d-flex aling-items-center p-2 gap-1">
						<i class='bx bxs-user-circle font-size-18 icon' style="display: {{$template->general_menu_icons == "off" ? "none" : "block"}}"></i>
						<span>Menú item</span>
					</div>
				</div>
			</div>
			<div class="col-8 p-0">
				<div class="p-0">
					<div id="headerPreview" class="position-absolute top-0 p-3" style="background-color: {{$template->general_header_background_color ?? "#fff"}}; color: {{$template->general_header_font_color ?? "#fff"}}; font-family: {{$template->general_header_font ?? "Arial"}}; width: 100%">
						Header
					</div>
				</div>
				<div class="p-0">
					<div id="contentPreview" class="position-absolute top-50 start-50 translate-middle p-1" style="background-color: {{$template->general_body_background_color ?? "#fff"}}; color: {{$template->general_body_font_color ?? "#fff"}}; font-family: {{$template->general_body_font ?? "Arial"}}; width: 90%; height: 70%">
						<p>Título</p>
						@yield('contentPreview')
					</div>
				</div>
				<div class="p-0">
					<div id="footerPreview" class="position-absolute bottom-0 p-3 d-flex justify-content-between" style="background-color: {{$template->general_footer_background_color ?? "#fff"}}; color: {{$template->general_footer_font_color ?? "#fff"}}; font-family: {{$template->general_footer_font ?? "Arial"}}; width: 100%; font-size: 11px">
						<span>2023 © Copixil S.A. de C.V.</span> <span>Tema creado por Copixil</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>