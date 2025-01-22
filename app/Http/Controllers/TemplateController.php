<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TemplateRequest;

use App\Models\Template;
use App\Models\Font;

use App\Traits\UploadTrait;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class TemplateController extends Controller
{
	use UploadTrait;

    public function update(Request $request)
    {
		
        $status = true;
		$template = Template::find($request->data['id']);
        $templateDB = json_decode($template->data, true);

        foreach ($request->data as $key => $value) {
            if(array_key_exists($key, $templateDB)){
                $templateDB[$key] = $request->data[$key];
            }else{
                $templateDB[$key] = $value;
            }
        }

		if(array_key_exists('general_header_font_id', $request->data)){
			$templateDB['general_header_font'] = Font::select('name')->whereId($request->data['general_header_font_id'])->first()->name;
			$templateDB['general_menu_font'] = Font::select('name')->whereId($request->data['general_menu_font_id'])->first()->name;
			$templateDB['general_body_font'] = Font::select('name')->whereId($request->data['general_body_font_id'])->first()->name;
			$templateDB['general_footer_font'] = Font::select('name')->whereId($request->data['general_footer_font_id'])->first()->name;
		}

		if(!array_key_exists('general_menu_icons', $request->data)){
			$templateDB['general_menu_icons'] = 'off';
		}

		if(array_key_exists('logo', $request->data)){
			$path = $this->uploadFile($request->data['logo'], 'images/logos');
			$templateDB['logo'] = $path;
		}
		$hex_color = $templateDB['datatables_header_backround_color']; 
		list($red, $green, $blue) = sscanf($hex_color, "#%02x%02x%02x"); 
		$templateDB['datatables_header_backround_color'] = sprintf('%d, %d, %d', $red, $green, $blue); 

		$params = [
            'data' => json_encode($templateDB),
			'updated_by' => auth()->id(),
			'updated_at' => date("Y-m-d H:i:s")
		];

		try {
			$template->update($params);

            $this->uploadJson(json_decode($template->data), "uploads/templates/template");
			
			$this->setTheme();

			$message = __('templates.Successfully updated');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'templates');
		}
		return redirect()->route('config_general.index');
    }

	public static function readTemplateJson($inArray = false)
    {
        $file = Storage::disk('public')->get('uploads/templates/template.json');
        $jsonDecode = json_decode($file, $inArray);

        return $jsonDecode;
    }

	public function updateTheme($idTemplate){
		return Template::find($idTemplate);
	}

	public static function betterFontColor($backgroundColor, $opacity) {
		// Convertimos el color de fondo a un objeto RGBA
		$rgba = TemplateController::rgbToRgba($backgroundColor, $opacity);
		$r = $rgba["r"] / $rgba["a"];
		$g = $rgba["g"] / $rgba["a"];
		$b = $rgba["b"] / $rgba["a"];
		
		// Calculamos la luminosidad del fondo usando la fórmula de W3C
		$luminisity = 0.2126 * $r + 0.7152 * $g + 0.0722 * $b;

		// Si la luminosidad es menor que 128, usamos texto blanco, de lo contrario usamos texto negro
		return $luminisity < 128 ? "#ffffff" : "#000000";
	}
	
	// Función auxiliar para convertir un color hexadecimal a RGBA
	public static function rgbToRgba($backgroundColor, $opacity) {
		$rgb = explode(",", $backgroundColor);
		$r = isset($rgb[0]) ? intval(trim($rgb[0])) : 0;
		$g = isset($rgb[1]) ? intval(trim($rgb[1])) : 0;
		$b = isset($rgb[2]) ? intval(trim($rgb[2])) : 0;
		return array("r" => $r, "g" => $g, "b" => $b, "a" => $opacity);
	}
	

	public static function setTheme(){
		$template = TemplateController::readTemplateJson();
		$file = fopen('public/css/variables.css', 'w');

		$display = $template->general_menu_icons == 'on' ? 'inline-block' : 'none'; 
		$css = ":root{

			/* GENERALES */
			/* Header */
			--general-header-background-color: {$template->general_header_background_color};
			--general-header-font-color: {$template->general_header_font_color};
			--general-header-font: {$template->general_header_font};

		
			/* Menu */
			--general-menu-background-color: {$template->general_menu_background_color}; 
			--general-menu-font-color: {$template->general_menu_font_color};
			--general-menu-font: {$template->general_menu_font};
			--general-active-menu-font-color: {$template->general_menu_font_hover_color};
			--general-menu-icons: {$display};
		
			/* Body */
			--general-body-background-color: {$template->general_body_background_color};
			--general-body-font-color: {$template->general_body_font_color};
			--general-body-font: {$template->general_body_font};

			/* Footer */
			--general-footer-background-color: {$template->general_footer_background_color};
			--general-footer-font-color: {$template->general_footer_font_color};
			--general-footer-font: {$template->general_footer_font};

			/* DATATABLES */
			/* Header */
			--datatables-header-background-color: {$template->datatables_header_backround_color};
			--datatables-header-font-color: {$template->datatables_header_font_color};
			--datatables-header-hover-font-color: ". TemplateController::betterFontColor($template->datatables_header_backround_color, 0.5). ";

			/* Boton Add */
			--datatables-add-background-color: {$template->datatables_add_background_color};
			--datatables-add-font-color: {$template->datatables_add_font_color};

			/* Boton Edit */
			--datatables-edit-font-color: {$template->datatables_edit_font_color};

			/* Boton Delete */
			--datatables-delete-font-color: {$template->datatables_delete_font_color};

		}
		
		
		/* General */


		#logo{
			background-image: url('../". $template->logo ."') !important;
			background-repeat: no-repeat !important;
			background-position: center !important; /* Center the image */
			background-size: contain  !important; /* Resize the background image to cover the entire container */
			height: 80px;
		}
		
		/* Header */
		#page-topbar{
			background-color: var(--general-header-background-color) !important;
			color: var(--general-header-font-color);
			font-family:  var(--general-header-font);

		}
		
		/* Menu */
		body[data-sidebar=dark] .vertical-menu,
		body[data-sidebar=dark] .navbar-brand-box,
		body[data-sidebar=dark].vertical-collpsed .vertical-menu #sidebar-menu > ul > li:hover > a,
		body[data-sidebar=dark].vertical-collpsed .vertical-menu #sidebar-menu > ul ul {
			background-color:  var(--general-menu-background-color) !important;
			font-family:  var(--general-menu-font) !important;
		}
		
		body[data-sidebar=dark] #sidebar-menu ul li ul.sub-menu li a,
		body[data-sidebar=dark] #sidebar-menu ul li a i, 
		body[data-sidebar=dark] #sidebar-menu ul li a
		{
			color: var(--general-menu-font-color) !important;
		}

		
		/* Menu item active */
		body[data-sidebar=dark] #sidebar-menu ul li ul.sub-menu li a:hover,
		body[data-sidebar=dark] #sidebar-menu ul li a:hover i,
		body[data-sidebar=dark] #sidebar-menu ul li a:hover,
		body[data-sidebar=dark] .mm-active > a,
		body[data-sidebar=dark] .mm-active > a i,
		body[data-sidebar=dark] .mm-active .active,
		body[data-sidebar=dark] .mm-active .active i
		{
			color: var(--general-active-menu-font-color) !important;
		}

		body[data-sidebar=dark] #sidebar-menu ul li a i {
			display: var(--general-menu-icons);
		}
		
		/* Body */
		body{
			background-color: var(--general-body-background-color);
		}
		
		.page-content,
		h1, h2 ,h3,
		h4, h5, h6{
			color: var(--general-body-font-color);
			font-family:  var(--general-body-font);
		}
		
		/* Footer */
		.footer {
			background-color: var(--general-footer-background-color);
			color: var(--general-footer-font-color);
			font-family:  var(--general-footer-font);
		}
		
		/* DATATABLES */
		.table thead {
			background-color: rgb(var(--datatables-header-background-color)) !important;
			color: var(--datatables-header-font-color) !important;
		}

		.table tbody tr:hover td {
			background-color: rgba(var(--datatables-header-background-color), 0.5) !important;
			color: var(--datatables-header-hover-font-color) !important;
		}

		.table tbody tr.odd {
			background-color: rgba(var(--datatables-header-background-color), 0.20) !important;
			color: var(--datatables-header-odd-font-color) !important;
		}

		.button-add, .paginate-button.active.page-link, .page-item.active .page-link {
			background-color: var(--datatables-add-background-color) !important;
			color: var(--datatables-add-font-color) !important;
		}

		.btn-primary {
			background-color: var(--datatables-add-background-color) !important;
			color: var(--datatables-add-font-color) !important;
			border-color: var(--datatables-add-background-color) !important;
		}

		.icon-edit{
			color: var(--datatables-edit-font-color);
		}

		.icon-delete{
			color: var(--datatables-delete-font-color);
		}

		.dt-button-collection .buttons-columnVisibility.active{
			background-color: rgba(var(--datatables-header-background-color), 0.50) !important;
			color: var(--datatables-header-font-color) !important;
		}

		.nav-tabs .nav-link {
			border: 1px solid #8080803d !important;
		}

		.nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
			color: var(--datatables-header-font-color) !important;
			background-color: rgb(var(--datatables-header-background-color)) !important;
		}

		.swal2-styled.swal2-confirm {
			background-color: var(--datatables-add-background-color) !important;
			color: var(--datatables-add-font-color) !important;
			padding: 30px;
		}
		.swal2-styled.swal2-confirm:focus {
			box-shadow: 0 0 0 3px rgba(var(--datatables-header-background-color), 0.5) !important;
		}

		.table.dataTable.dtr-inline.collapsed > tbody > tr > td.dtr-control:before, table.dataTable.dtr-inline.collapsed > tbody > tr > td.dtr-control:before {
			background-color: var(--datatables-add-background-color) !important;
		}
		";

		

		fwrite($file, $css);
		fclose($file);


		Artisan::call('config:cache');
		Artisan::call('config:clear');
		Artisan::call('cache:clear');

	}


}
