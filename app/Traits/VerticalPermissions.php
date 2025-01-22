<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use App\Scopes\VerticalPermissionsScope;
use App\VpermissionVpermission;

trait VerticalPermissions
{
	public static function bootVerticalPermissions()
	{
		//Get the related table data
		$relatedTable = (new self)->getRelatedTable();
		//Only if there is a related table we add a scope
		if($relatedTable != false)
			static::addGlobalScope(new VerticalPermissionsScope($relatedTable));
	}

	/**
	 * [getRelatedTable Search if the current table is registed in the table verticalpermission]
	 * @return [type] [description]
	 */
	private function getRelatedTable() {
		$result = false;
		//Get the table associated to the current model
		$currentModel = $this->getTable();
		//Search in the table verticalpermissions if the current model is defined as vertical permissions
		$entity = VpermissionVpermission::whereHas('entity', function (Builder $query) use ($currentModel) {
			$query->where('name', $currentModel);
		})->first();

		if($entity != NULL) {
			$hasMany = true;
			//The param tablename is converted from (snake case) to (camel case) to match a relationship function in the model
			//Example "selling_user" is converted to "sellingUser" and this name is required to exist as relationship in the model
			$tablename = "";
			
			//Vertical permissions can be applied using a derivated table (many to many) or using a column in the same table.
			//If main table (entity_id) and the related table (tablename_id) are the same table then we set the property hasMany as false
			if($entity->entity_id == $entity->tablename_id)
				$hasMany = false;
			else 
				$tablename = $this->toCamelcase($entity->tablename->name);
			
			//The column name we'll use to match to users table. 
			//Have to be a valid column name from the table tablename_id
			$fieldname = $entity->attribute_name;
			
			$result = compact('hasMany', 'tablename', 'fieldname');
		}

		return $result;
	}

	private function toCamelcase($input, $separator = '_')
	{
		return lcfirst(str_replace($separator, '', ucwords($input, $separator)));
	}
}