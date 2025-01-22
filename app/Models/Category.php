<?php

namespace App\Models;

use App\Traits\SelectTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
	use HasFactory, SelectTrait;
	
	protected $table = 'categories';
	protected $fillable = ['category_id', 'name', 'description', 'notes', 'is_active', 'is_visible', 'print_order', 'created_by', 'updated_by', 'created_at', 'updated_at'];

	public function category()
	{
		return $this->belongsTo('App\Models\Category', 'category_id');
	}
	public function createdBy()
	{
		return $this->belongsTo('App\Models\User', 'created_by');
	}
	public function updatedBy()
	{
		return $this->belongsTo('App\Models\User', 'updated_by');
	}
	
	public function categories()
	{
		return $this->hasMany('App\Models\Category');
	}
	
	public function ingredients()
	{
		return $this->hasMany('App\Models\Ingredient');
	}
	
	public function products()
	{
		return $this->hasMany('App\Models\Product');
	}
	
}