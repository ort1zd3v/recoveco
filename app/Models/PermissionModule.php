<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionModule extends Model
{
	use HasFactory;
	
	public function permissions()
	{
		return $this->hasMany('App\Models\PermissionPermission', 'module_id', 'id');
	}
	public function entities()
	{
		return $this->belongsToMany('App\Models\PermissionEntity', 'permission_entity_module', 'module_id', 'entity_id');
	}

	public function modulePermissions($modules) {
		foreach ($modules as $key => $module) {
			//Buscar los modulos hijos
			if($module->module_type_id == 1) {
				$submodules = $this->with(["permissions", "permissions.permissionFunction"])->where("module_id", $module->id)->get();
				$module->modules = $this->modulePermissions($submodules);
			}
		}
		return $modules;
	}

	public function permissionsByModule()
	{
		$mModules = $this->with(["permissions", "permissions.permissionFunction"])->where("module_id", null)->get();
		return $this->modulePermissions($mModules);
	}
}
