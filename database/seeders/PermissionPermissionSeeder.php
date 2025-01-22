<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;
use App\Models\PermissionFunction;
use App\Models\PermissionPermission;

class PermissionPermissionSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		/* Dashboard */
		$this->createPermissions(["dashboard"], ["index"], false);
		
		/** Users */
		$this->createPermissions(["roles"], ["permissions", "savePermissions", "getAll"]);
		$this->createPermissions(["users"], ["permissions", "savePermissions", "getAll", "getDetailsData"]);

		/** Products */
		$this->createPermissions(['products'], ['jsonproducts', 'getproducttableview', 'getproducttableajax']);
		$this->createPermissions(["categories"]);
		$this->createPermissions(["unit_types"]);

		/** Revovequeros **/
		$this->createPermissions(["suppliers"]);

		/** Pos */
		$this->createPermissions(["pos"], ['saveSale', 'addcartproduct', 'getingredientsmodal']);
		$this->createPermissions(["ingredients"], ['getdatatable']);

		/** Configuration */
		$this->createPermissions(["config_general"], ['getPartOfPreview']);
		$this->createPermissions(["config_pos"], ['getViews', 'getView', 'getConfigView', 'saveConfigView', 'index', 'update']);
		$this->createPermissions(["config_tickets"], ['getTicket']);

		/** Templates */
		$this->createPermissions(["templates"], ['updateTheme']);
		
		/** Clients */
		$this->createPermissions(["clients"]);

		/** Reports */
		$this->createPermissions(["sellings"]);
		$this->createPermissions(["starting_founds"], ['show', 'closeDay', 'initDay']);
		$this->createPermissions(["report_by_years"], ['index', 'getByMonth', 'getYearDetail'], false);
		$this->createPermissions(["report_by_months"], ['index', 'getByDay', 'getMonthDetail'], false);
		$this->createPermissions(["report_by_days"], ['index', 'getDayDetail'], false);

		$this->createPermissions(["inventories", "inventory_movements"]);
	}

	/**
	 * [createPermissions Permisos para los modulos de usuarios y roles 
	 * donde se agregan las funciones básicas y función de guardar permisos]
	 */
	public function createPermissions($moduleNames = [], $functionNames = [], $addCrudFunctions = true) {
		$defaultFunctions = ["index","store","create","update","destroy","edit", "getbyparam", "getquickmodalcontent"];
		$modules = PermissionModule::where('module_type_id', '2')->whereIn('name', $moduleNames)->get();
		if($addCrudFunctions) {
			$functionNames = array_merge($defaultFunctions, $functionNames);
		}
		$functions = PermissionFunction::whereIn('name', $functionNames)->get();
		
		foreach ($modules as $key => $module) {
			foreach ($functions as $key => $function) {
				PermissionPermission::create(["module_id" => $module->id, "function_id" => $function->id]);
			}
		}
	}
}
