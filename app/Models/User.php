<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
	use HasApiTokens, HasFactory, Notifiable;
	
	protected $table = 'users';
	protected $fillable = ['role_id', 'name', 'paternal_surname', 'maternal_surname', 'picture', 'email', 'email_verified_at', 'password', 'remember_token', 'created_at', 'updated_at'];
	protected $hidden = ['password', 'remember_token','email_verified_at'];

	public function role()
	{
		return $this->belongsTo('App\Models\Role', 'role_id');
	}
	
	//Mod permissions
	public function permissionPermissionUsers()
	{
		return $this->hasMany('App\Models\PermissionPermissionUser');
	}

	public function permissions()
	{
		return $this->belongsToMany('App\Models\PermissionPermission', 'permission_permission_user', 'user_id', 'permission_id');
	}

	public function permissionsArray()
	{
		$permissions = [];
		foreach ($this->permissions as $key => $permission) {
			$permissions[$permission->id] = $permission;
		}
		return $permissions;
	}

	public function getAllPermissions()
	{
		$userPermissions = $this->permissions;
		$rolePermissions = $this->role->permissions;
		return $userPermissions->merge($rolePermissions); 
	}

	public function getAllPermissionsArray()
	{
		$permissions = $this->getAllPermissions();
		$result = [];
		foreach ($permissions as $key => $permission) {
			$result[$permission->id] = $permission;
		}

		return $result;
	}

	public function getFullName()
	{
		return $this->name.' '.$this->paternal_surname.' '.$this->maternal_surname;
	}

	public function hasPermissions($route_name)
	{
		$result = false;
		$permissions = $this->getAllPermissions();
		foreach ($permissions as $key => $permission) {
			if($permission->permissionModule->name.".".$permission->permissionFunction->name == $route_name) {
				$result = true;
				break;
			}
		}
		return $result;
	}

	//Autocomplete
	public static function getUser()
	{
		return static::select('id', DB::raw("CONCAT_WS(' ', name, paternal_surname, maternal_surname, ',', email) as value"));
	}
}