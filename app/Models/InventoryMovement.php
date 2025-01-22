<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
	use HasFactory;
	
	protected $table = 'inventory_movements';
	protected $fillable = ['product_id', 'inventory_movement_type_id', 'amount', 'notes', 'is_active', 'created_by', 'updated_by', 'created_at', 'updated_at'];

	public function createdBy()
	{
		return $this->belongsTo('App\Models\User', 'created_by');
	}
	public function inventoryMovementType()
	{
		return $this->belongsTo('App\Models\InventoryMovementType', 'inventory_movement_type_id');
	}
	public function product()
	{
		return $this->belongsTo('App\Models\Product', 'product_id');
	}
	public function updatedBy()
	{
		return $this->belongsTo('App\Models\User', 'updated_by');
	}
	
}