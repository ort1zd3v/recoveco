<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainmenuViewname extends Model
{
	use HasFactory;
	
	protected $table = 'mainmenu_viewnames';
	protected $fillable = ['name', 'description', 'permission_id', 'created_at', 'updated_at'];

	public function permission()
	{
		return $this->belongsTo('App\Models\PermissionPermission', 'permission_id');
	}
	
	public function mainmenuMainmenuses()
	{
		return $this->hasMany('App\Models\MainmenuMainmenu');
	}
	
}