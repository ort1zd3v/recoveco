<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainmenuMainmenu extends Model
{
	use HasFactory;

	protected $table = 'mainmenu_mainmenus';
	protected $fillable = ['name', 'description', 'icon', 'link', 'menu_position', 'mainmenu_status_id', 'viewname_id', 'mainmenu_id', 'created_at', 'updated_at'];

	public function mainmenu()
	{
		return $this->belongsTo('App\Models\MainmenuMainmenu', 'mainmenu_id');
	}
	public function mainmenuStatus()
	{
		return $this->belongsTo('App\Models\MainmenuMainmenuStatus', 'mainmenu_status_id');
	}
	public function viewname()
	{
		return $this->belongsTo('App\Models\MainmenuViewname', 'viewname_id');
	}
	
	public function mainmenuMainmenuses()
	{
		return $this->hasMany('App\Models\MainmenuMainmenu');
	}
}