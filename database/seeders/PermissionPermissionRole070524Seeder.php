<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionPermission;
use App\Models\PermissionModule;
use App\Models\PermissionPermissionRole;

class PermissionPermissionRole070524Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules = PermissionModule::whereIn("name", [
			"add_inventories", 
			"report_by_sellings"
        ])->where("module_type_id", 2)->get('id');

        $permissions = PermissionPermission::whereIn("module_id", $modules)->get();

		foreach ($permissions as $key => $permission) {
			PermissionPermissionRole::create(["permission_id" => $permission->id, "role_id" => 1]);
		}
    }
}
