<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;

class PermissionModule5Seeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$module = PermissionModule::where("name", "reports")->first();
		PermissionModule::create(["name" => "report_by_sellings", "module_type_id" => 2, "module_id" => $module->id]);

		$module = PermissionModule::where("name", "inventories")->first();
		PermissionModule::create(["name" => "add_inventories", "module_type_id" => 2, "module_id" => $module->id]);
	}
}