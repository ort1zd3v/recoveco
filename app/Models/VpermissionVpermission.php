<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VpermissionVpermission extends Model
{
	use HasFactory;
	
	protected $fillable = ['entity_id', 'tablename_id', 'attribute_name'];

	public function entity()
	{
		return $this->belongsTo('App\Models\VpermissionTablename', 'entity_id', 'id');
	}
	public function tablename()
	{
		return $this->belongsTo('App\Models\VpermissionTablename', 'tablename_id', 'id');
	}
}
