<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientValue extends Model
{
	use HasFactory;
	
	protected $table = 'client_values';
	protected $fillable = ['client_id', 'client_attribute_id', 'value', 'notes', 'is_active', 'created_by', 'updated_by', 'created_at', 'updated_at'];

	public function clientAttribute()
	{
		return $this->belongsTo('App\Models\ClientAttribute', 'client_attribute_id');
	}
	public function client()
	{
		return $this->belongsTo('App\Models\Client', 'client_id');
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