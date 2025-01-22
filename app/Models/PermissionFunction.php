<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionFunction extends Model
{
	use HasFactory;
	
	protected $table = 'permission_functions';
	protected $fillable = ['name', 'created_at', 'updated_at'];
	
	public function permissionPermissions()
	{
		return $this->hasMany('App\Models\PermissionPermission');
	}
	
}