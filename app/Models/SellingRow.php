<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellingRow extends Model
{
	use HasFactory;
	
	protected $table = 'selling_rows';
	protected $fillable = ['selling_id', 'product_id', 'parent_product_id', 'description', 'amount', 'unit_price', 'subtotal', 'iva', 'total_price', 'commission_percentage', 'notes', 'is_active', 'created_by', 'updated_by', 'created_at', 'updated_at'];

	public function createdBy()
	{
		return $this->belongsTo('App\Models\User',
		 'created_by');
	}
	public function product()
	{
		return $this->belongsTo('App\Models\Product',
		 'product_id');
	}
	public function selling()
	{
		return $this->belongsTo('App\Models\Selling',
		 'selling_id');
	}
	public function updatedBy()
	{
		return $this->belongsTo('App\Models\User',
		 'updated_by');
	}
	
}