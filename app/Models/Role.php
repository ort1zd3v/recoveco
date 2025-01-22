<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	use HasFactory;
	
	protected $table = 'roles';
	protected $fillable = ['name', 'description', 'created_at', 'updated_at'];
	
	public function permissionPermissionRoles()
	{
		return $this->hasMany('App\Models\PermissionPermissionRole');
	}
	
	public function users()
	{
		return $this->hasMany('App\Models\User');
	}

	public function permissions()
	{
		return $this->belongsToMany('App\Models\PermissionPermission', 'permission_permission_role', 'role_id', 'permission_id');
	}

	public function permissionsArray()
	{
		$permissions = [];
		foreach ($this->permissions as $key => $permission) {
			$permissions[$permission->id] = $permission;
		}
		return $permissions;
	}
}