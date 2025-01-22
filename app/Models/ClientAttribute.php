<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientAttribute extends Model
{
	use HasFactory;
	
	protected $table = 'client_attributes';
	protected $fillable = ['name', 'description', 'is_required', 'notes', 'is_active', 'created_by', 'updated_by', 'created_at', 'updated_at'];

	public function createdBy()
	{
		return $this->belongsTo('App\Models\User', 'created_by');
	}
	public function updatedBy()
	{
		return $this->belongsTo('App\Models\User', 'updated_by');
	}
	
	public function clientValues()
	{
		return $this->hasMany('App\Models\ClientValue');
	}
	
}