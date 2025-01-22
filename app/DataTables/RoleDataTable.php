<?php

namespace App\DataTables;

use App\Models\Role;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RoleDataTable extends BlankDataTable
{
	public function __construct()
	{
		$this->routeResource = 'roles';
	}
	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\Selling $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query(Role $model)
	{
		return $model
		->newQuery();
	}

	/**
	 * Get columns.
	 *
	 * @return array
	 */
	protected function getColumns()
	{
		$pColumns = parent::getColumns();
		$columns = [
			['data' => 'id', 'visible' => false],
			['data' => 'name', 'title' => __('roles.name')],
			['data' => 'description', 'title' => __('roles.description')],
			['data' => 'created_at', 'visible' => false],
			['data' => 'updated_at', 'visible' => false],
		];
		return array_merge($columns, $pColumns);
	}

	public function getActions($row)
	{
		$result = parent::getActions($row);
		if(auth()->user()->hasPermissions($this->routeResource.".permissions")) {
			$result .= '<a href="'.route($this->routeResource.".permissions", $row->id).'">
				<button type="button" class="btn btn-default" title='.__('roles.permissions').'>
					<i class="fa fa-keyboard"></i>
				</button>
			</a>';
		}

		return $result;
	}
}
