<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
	use HasFactory;
	
	protected $table = 'ingredients';
	protected $fillable = ['product_id', 'ingredient_id', 'category_id', 'amount', 'notes', 'is_active', 'created_by', 'updated_by', 'created_at', 'updated_at'];

	public function category()
	{
		return $this->belongsTo('App\Models\Category', 'category_id');
	}
	public function createdBy()
	{
		return $this->belongsTo('App\Models\User', 'created_by');
	}
	public function ingredient()
	{
		return $this->belongsTo('App\Models\Product', 'ingredient_id');
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