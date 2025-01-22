<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MainmenuViewname;
use App\Models\PermissionModule;
use App\Models\PermissionFunction;
use App\Models\PermissionPermission;

class MainmenuViewname4Seeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//Busca en la tabla módulos todos los registros que sean vistas (elementos que tienen permisos)
		//Luego los iteramos para obtener su permiso correspondiente y así creamos una relación entre la vista y el permiso
		$mod = [
			"report_by_payment_types", 
		];

		$modules = PermissionModule::whereIn('name', $mod)->get();

		
		foreach ($modules as $key => $module) {
			$function = PermissionFunction::where("name", "index")->first();
			$permission = PermissionPermission::where(["module_id" => $module->id, "function_id" => $function->id])->first();
			if ($permission != null) {
				MainmenuViewname::create(["name" => $module->name, "permission_id" => $permission->id]);
			}
		}
	}
}
