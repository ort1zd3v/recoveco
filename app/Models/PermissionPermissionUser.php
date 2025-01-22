<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PermissionPermissionUser extends Pivot
{
	public function permission() {
		return $this->belongsTo('App\Models\PermissionPermission', 'permission_id', 'id');
	}

	public function user() {
		return $this->belongsTo('App\Models\User');
	}
}
