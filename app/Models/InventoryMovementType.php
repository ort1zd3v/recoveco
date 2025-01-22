<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryMovementType extends Model
{
	use HasFactory;
	
	protected $table = 'inventory_movement_types';
	protected $fillable = ['name', 'notes', 'is_active', 'created_by', 'updated_by', 'created_at', 'updated_at'];

	public function createdBy()
	{
		return $this->belongsTo('App\Models\User', 'created_by');
	}
	public function updatedBy()
	{
		return $this->belongsTo('App\Models\User', 'updated_by');
	}
	
	public function inventoryMovements()
	{
		return $this->hasMany('App\Models\InventoryMovement');
	}
	
}