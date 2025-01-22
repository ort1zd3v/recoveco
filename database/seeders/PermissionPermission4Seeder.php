<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;
use App\Models\PermissionFunction;
use App\Models\PermissionPermission;

class PermissionPermission4Seeder extends PermissionPermissionSeeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->createPermissions(["pos"], ['searchProduct'], false);
		$this->createPermissions(["report_by_suppliers"], ['exportExcel'], false);
	}
}