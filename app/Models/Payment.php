<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
	use HasFactory;
	
	protected $table = 'payments';
	protected $fillable = ['payment_type_id', 'selling_id', 'amount', 'notes', 'is_active', 'created_by', 'updated_by', 'created_at', 'updated_at'];

	public function createdBy()
	{
		return $this->belongsTo('App\Models\User', 'created_by');
	}
	public function paymentType()
	{
		return $this->belongsTo('App\Models\PaymentType', 'payment_type_id');
	}
	public function selling()
	{
		return $this->belongsTo('App\Models\Selling', 'selling_id');
	}
	public function updatedBy()
	{
		return $this->belongsTo('App\Models\User', 'updated_by');
	}
}