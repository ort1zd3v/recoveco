<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;

class PermissionModuleSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		PermissionModule::create(["name" => "dashboard", "module_type_id" => 2]);
		
		/** Users */
		$module = PermissionModule::create(["name" => "Users", "module_type_id" => 1]);
		PermissionModule::create(["name" => "users", "module_type_id" => 2, "module_id" => $module->id]);
		PermissionModule::create(["name" => "roles", "module_type_id" => 2, "module_id" => $module->id]);
		
		/** Products */
		$module = PermissionModule::create(["name" => "Products", "module_type_id" => 1]);
		PermissionModule::create(["name" => "products", "module_type_id" => 2, "module_id" => $module->id]);
		PermissionModule::create(["name" => "categories", "module_type_id" => 2, "module_id" => $module->id]);
		PermissionModule::create(["name" => "unit_types", "module_type_id" => 2, "module_id" => $module->id]);

		/** Pos */
		$module = PermissionModule::create(["name" => "Pos", "module_type_id" => 1]);
		PermissionModule::create(["name" => "pos", "module_type_id" => 2, "module_id" => $module->id]);
		PermissionModule::create(["name" => "ingredients", "module_type_id" => 2, "module_id" => $module->id]);

		/** Configuration */
		$module = PermissionModule::create(["name" => "Configuration", "module_type_id" => 1]);
		PermissionModule::create(["name" => "config_general", "module_type_id" => 2, "module_id" => $module->id]);
		PermissionModule::create(["name" => "config_pos", "module_type_id" => 2, "module_id" => $module->id]);
		PermissionModule::create(["name" => "config_tickets", "module_type_id" => 2, "module_id" => $module->id]);

		/** Recovequeros (proveedores) */
		PermissionModule::create(["name" => "suppliers", "module_type_id" => 2]);

		/** Templates */
		$module = PermissionModule::create(["name" => "Templates", "module_type_id" => 1]);
		PermissionModule::create(["name" => "templates", "module_type_id" => 2, "module_id" => $module->id]);
		/** Clients */
		$module = PermissionModule::create(["name" => "Clients", "module_type_id" => 1]);
		PermissionModule::create(["name" => "clients", "module_type_id" => 2, "module_id" => $module->id]);


		/** Sellings - Reports*/
		$module = PermissionModule::create(["name" => "Reports", "module_type_id" => 1]);
		PermissionModule::create(["name" => "starting_founds", "module_type_id" => 2, "module_id" => $module->id]);
		PermissionModule::create(["name" => "sellings", "module_type_id" => 2, "module_id" => $module->id]);
		PermissionModule::create(["name" => "report_by_years", "module_type_id" => 2, "module_id" => $module->id]);
		PermissionModule::create(["name" => "report_by_months", "module_type_id" => 2, "module_id" => $module->id]);
		PermissionModule::create(["name" => "report_by_days", "module_type_id" => 2, "module_id" => $module->id]);

		
		/** Inventories */
		$module = PermissionModule::create(["name" => "inventories", "module_type_id" => 1]);
		PermissionModule::create(["name" => "inventories", "module_type_id" => 2, "module_id" => $module->id]);
		PermissionModule::create(["name" => "inventory_movements", "module_type_id" => 2, "module_id" => $module->id]);

	}
}