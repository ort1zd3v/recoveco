<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Selling extends Model
{
	use HasFactory;
	
	protected $table = 'sellings';
	protected $fillable = ['client_id', 'points', 'subtotal', 'iva', 'total', 'notes', 'is_active', 'created_by', 'updated_by', 'created_at', 'updated_at'];

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
	
	public function payments()
	{
		return $this->hasMany('App\Models\Payment');
	}
	
	public function sellingRows()
	{
		return $this->hasMany('App\Models\SellingRow');
	}
}