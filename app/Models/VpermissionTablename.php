<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VpermissionTablename extends Model
{
	use HasFactory;
	
	protected $fillable = ['name'];

	public function userTablenames()
	{
		return $this->belongsTo('App\Models\VpermissionUserTablename');
	}
}
