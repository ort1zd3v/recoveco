<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PermissionPermissionRole extends Pivot
{
	protected $fillable = ['permission_id', 'role_id', 'created_at', 'updated_at'];
	
	public function permission() {
		return $this->belongsTo('App\Models\PermissionPermission', 'permission_id', 'id');
	}

	public function role() {
		return $this->belongsTo('App\Models\Role');
	}
}
