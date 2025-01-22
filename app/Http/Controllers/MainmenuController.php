<?php

namespace App\Http\Controllers;

use App\Models\MainmenuMainmenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class MainmenuController extends Controller
{
	public $permissionsArray;
	/**
	 * [getMenus Obtiene los elementos del menú]
	 * @return [Array]
	 */
	public function getMenus()
	{
		$menus = MainmenuMainmenu::with(['viewname.permission.permissionFunction', 'viewname.permission.permissionModule'])
			->where("mainmenu_status_id", "1")->orderBy("menu_position", "ASC")->get()->toArray();
		$this->permissionsArray = auth()->user()->getAllPermissionsArray();
		return $this->getSubmenus($menus, NULL);
	}

	/**
	 * [getSubmenus Genera un array estructurado de los menús y submenús]
	 * @param  [type] $menus            [description]
	 * @param  [type] $mainmenu_id      [Parent menu]
	 * @return [type]                   [description]
	 */
	public function getSubmenus($menus, $mainmenu_id)
	{
		$result = [];
		foreach ($menus as $key => $menu) {
			//Solo itera los elementos que coincidan con el parent dado, la primera iteración siempre es NULL
			if($menu["mainmenu_id"] == $mainmenu_id) {
				//Remover el elemento del array para evitar volver a iterarlo
				unset($menus[$key]);
				//Si el elemento tiene viewname entonces será un link de lo contrario será un submenú
				if($menu["viewname_id"] != NULL) {
					if(isset($this->permissionsArray[$menu["viewname"]["permission_id"]])) {
						//Set menu link
						$module = $menu["viewname"]["permission"]["permission_module"];
						$function = $menu["viewname"]["permission"]["permission_function"];
						$menu["link"] = $module["name"].".".$function["name"];
						//$menu["active"] = $this->getActive($module, $function, $menu["link"]);
						
					}
				} else {
					$submenus = $this->getSubmenus($menus, $menu["id"]);
					if(!empty($submenus)) {
						$menu["link"] = "submenu".ucfirst($menu["name"]);
						
						//Revisar en los hijos si algun de ellos está activo para poder activo el submenú
						$menu["active"] = false;
						foreach ($submenus as $key => $value) {
							if($value["active"] ?? false) {
								$menu["active"] = true;
								break;
							}
						}
						$menu["submenus"] = $submenus;
					}
				}
				if ($menu["link"] != null) {
					$result[$menu["id"]] = $menu;
				}
			}
		}
		return $result;
	}

	/**
	 * [getActive Validar si el menú debe estar activo o no]
	 * @param  [String] $module   [Nombre del módulo]
	 * @param  [String] $function [Nombre de la función]
	 * @param  [String] $link     [Link del menú]
	 * @return [Boolean]
	 */
	public function getActive($module, $function, $link)
	{
		$menuActive = false;
		//Si el link del menú es un index y estamos navegando en cualquiera de sus rutas (create, view, edit)
		if($function["name"] == "index") {
			$fullView = explode(".", Route::getCurrentRoute()->getName());
			if($module["name"] == $fullView[0]) {
				$menuActive = true;
			}
		}
		//Si el link es un link personalizado (Ejemplo: sellings.selling)
		else {
			if($link == Route::getCurrentRoute()->getName()) {
				$menuActive = true;
			}
		}

		return $menuActive;
	}
}
