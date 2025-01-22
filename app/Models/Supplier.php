<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SelectTrait;

class Supplier extends Model
{
	use HasFactory, SelectTrait;
	
	protected $table = 'suppliers';
	protected $fillable = ['name', 'description', 'commission_percentage', 'notes', 'is_active', 'created_by', 'updated_by', 'created_at', 'updated_at'];

	public function createdBy()
	{
		return $this->belongsTo('App\Models\User', 'created_by');
	}
	public function updatedBy()
	{
		return $this->belongsTo('App\Models\User', 'updated_by');
	}
	
	public function buyings()
	{
		return $this->hasMany('App\Models\Buying');
	}
	
	public function supplierAddresses()
	{
		return $this->hasMany('App\Models\SupplierAddress');
	}

	public function products()
    {
        return $this->hasMany('App\Models\Product', 'supplier_id');
    }

	//Autocomplete
	public static function getSupplier()
	{
		return static::select('id', 'name as value')->orderBy('name', 'asc');
	}
	
}