<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StartingFound extends Model
{
	use HasFactory;
	
	protected $table = 'starting_founds';
	protected $fillable = ['amount', 'initial_date', 'final_date', 'initial_user_id', 'final_user_id', 'notes', 'is_active', 'created_by', 'updated_by', 'created_at', 'updated_at'];

	public function initialUser()
	{
		return $this->belongsTo('App\Models\User', 'initial_user_id');
	}
	public function finalUser()
	{
		return $this->belongsTo('App\Models\User', 'final_user_id');
	}

	public function createdBy()
	{
		return $this->belongsTo('App\Models\User', 'created_by');
	}
	public function updatedBy()
	{
		return $this->belongsTo('App\Models\User', 'updated_by');
	}
	
}