<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
	use HasFactory;
	
	protected $table = 'clients';
	protected $fillable = ['id', 'name', 'client_number', 'points', 'branch_id', 'notes', 'is_active', 'created_by', 'updated_by', 'created_at', 'updated_at'];

	public function createdBy()
	{
		return $this->belongsTo('App\Models\User', 'created_by');
	}
	
	public function updatedBy()
	{
		return $this->belongsTo('App\Models\User', 'updated_by');
	}
	
	public function clientAddresses()
	{
		return $this->hasMany('App\Models\ClientAddress');
	}
	
	public function clientValues()
	{
		return $this->hasMany('App\Models\ClientValue');
	}
	
	public function sellings()
	{
		return $this->hasMany('App\Models\Selling');
	}
	
}