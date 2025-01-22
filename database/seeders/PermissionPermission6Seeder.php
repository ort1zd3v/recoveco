<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;
use App\Models\PermissionFunction;
use App\Models\PermissionPermission;

class PermissionPermission6Seeder extends PermissionPermissionSeeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->createPermissions(["add_inventories"], ['index', 'saveInventory', 'addCartInventory', 'searchProduct'], false);
		$this->createPermissions(["report_by_sellings"], ['index', 'exportExcel'], false);

	}

}
