<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainmenuMainmenuStatus extends Model
{
	use HasFactory;
	
	protected $table = 'mainmenu_mainmenu_statuses';
	protected $fillable = ['name', 'created_at', 'updated_at'];

	
	public function mainmenuMainmenuses()
	{
		return $this->hasMany('App\Models\MainmenuMainmenu');
	}
	
}