<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MainmenuMainmenu;
use App\Models\MainmenuViewname;

class MainmenuMainmenuSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$menus = [
			/** dashboard */
			[
				"name" => "dashboard",
				"icon" => '<i class="fas fa-tachometer-alt"></i>',
			],
			/** users */
			[
				"name" => "users",
				"icon" => '<i class="fas fa-user-alt"></i>',
				"children" => [
					["name" => "users", "icon" => '<i class="fas fa-user-alt"></i>'],
					["name" => "roles", "icon" => '<i class="fas fa-user-tag"></i>'],
				]
			],
			/** products */
			[
				"name" => "products",
				"icon" => '<i class="bx bxs-basket"></i>',
				"children" => [
					["name" => "products", "icon" => '<i class="bx bxs-basket"></i>'],
					["name" => "categories", "icon" => '<i class="bx bxs-purchase-tag" ></i>'],
					["name" => "unit_types", "icon" => '<i class="fas fa-user-alt"></i>'],
				]
			],
			/** suppliers */
			[
				"name" => "suppliers",
				"icon" => '<i class="bx bxs-user-pin"></i>',
			],
			// /** clients */
			// [
			// 	"name" => "clients",
			// 	"icon" => '<i class="bx bxs-user-badge" ></i>',
			// 	"children" => [
			// 		["name" => "clients", "icon" => '<i class="bx bxs-user-badge" ></i>'],
			// 	]
			// ],
			//Inventories
			[
				"name" => "inventories",
				"icon" => '<i class="bx bxs-box"></i>',
				"children" => [
					["name" => "inventories", "icon" => '<i class="bx bx-box"></i>'],
					["name" => "inventory_movements", "icon" => '<i class="bx bx-package"></i>'],
				]
			],
			/** pos */
			[
				"name" => "pos",
				"icon" => '<i class="bx bx-desktop" ></i>',
			],
			/** configuration */
			[
				"name" => "configuration",
				"icon" => '<i class="fas fa-cog"></i>',
				"children" => [
					["name" => "config_general", "icon" => '<i class="fas fa-palette"></i>'],
					["name" => "config_pos", "icon" => '<i class="bx bx-desktop" ></i>'],
					["name" => "config_tickets", "icon" => '<i class="bx bx-receipt"></i>'],
				]
			],
			/** reports */
			[
				"name" => "reports",
				"icon" => "<i class='bx bx-money'></i>",
				"children" => [
					// ["name" => "sellings", "icon" => '<i class="fas fa-palette"></i>'],
					["name" => "starting_founds", "icon" => "<i class='bx bx-wallet' ></i>"],
					["name" => "report_by_years", "icon" => "<i class='bx bxs-report'></i>"],
					["name" => "report_by_months", "icon" => "<i class='bx bxs-report'></i>"],
					["name" => "report_by_days", "icon" => "<i class='bx bxs-report'></i>"],
					["name" => "report_by_suppliers", "icon" => "<i class='bx bxs-report'></i>"],
					["name" => "report_by_tickets", "icon" => "<i class='bx bxs-report'></i>"],
					["name" => "report_by_payment_types", "icon" => "<i class='bx bxs-report'></i>"],
				]
			],
		];
		$this->createMenus($menus);
	}


	public function createMenus($menus)
	{
		foreach ($menus as $key => $value) {
			$this->createMenu($value);
		}
	}

	public $menuPosition = 0;
	public function createMenu($param, $menuPosition = null, $menu_id = null)
	{
		//Set menu position as incremental value
		if($menuPosition == null)
			$this->menuPosition += 10;

		//If the param array doesn't have items then we search the viewname 
		//to link with the menu we will create
		if(!isset($param["children"])) {
			$viewname = MainmenuViewname::where("name", $param["viewname"] ?? $param["name"])->first();
		}
		//Create the menu
		$menu = MainmenuMainmenu::create([
			"name" => $param["name"], 
			"description" => $param["description"] ?? $param["name"], 
			"icon" => $param["icon"] ?? '<i class="fas fa-user"></i>',
			"menu_position" => $menuPosition ?? $this->menuPosition, 
			"mainmenu_status_id" => "1",
			"viewname_id" => !isset($param["children"]) ? $viewname->id : null,
			"mainmenu_id" => $menu_id ?? null,
		]);

		//If the menu have submenus
		$cc = 0;
		foreach ($param["children"] ?? [] as $key => $value) {
			$cc++;
			$cPos = (floatval($this->menuPosition) * 10) + ($cc*10);
			$this->createMenu($value, $cPos, $menu->id);
		}
	}

	public function createSubmenu($parent, $submenuName, $icon = null)
	{
		$viewname = MainmenuViewname::where("name", $submenuName)->first();
		$parentMenu = MainmenuMainmenu::where("name", $parent)->first();
		$lastChild = MainmenuMainmenu::where("mainmenu_id", $parentMenu->id)->orderBy('menu_position', 'desc')->first();
		$menu = MainmenuMainmenu::create([
			"name" => $submenuName, 
			"description" => $submenuName, 
			"icon" => $icon ?? '<i class="fas fa-user"></i>',
			"menu_position" => $lastChild->menu_position + 10, 
			"mainmenu_status_id" => "1",
			"viewname_id" => $viewname->id,
			"mainmenu_id" => $parentMenu->id,
		]);
	}
}
