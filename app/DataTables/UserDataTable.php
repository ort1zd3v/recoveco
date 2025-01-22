<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends BlankDataTable
{
	public function __construct()
	{
		$this->routeResource = 'users';
	}
	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\Selling $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query(User $model)
	{
		return $model->select(
			'users.*',
			'roles.name as role_id'
		)
		->leftjoin('roles', 'users.role_id', '=', 'roles.id')
		->newQuery();
	}

	public function dataTable($query)
	{
		$datatable = parent::dataTable($query);
		$datatable->filter(function($query) {
			$query->orWhere('roles.name', 'LIKE', '%'.request('search.value').'%');
		}, true)->rawColumns(["action"]);
			
		return $datatable;
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
			['data' => 'role_id', 'title' => __('users.role_id'), 'name' => 'roles.id'],
			['data' => 'name', 'title' => __('users.name')],
			['data' => 'paternal_surname', 'title' => __('users.paternal_surname')],
			['data' => 'maternal_surname', 'title' => __('users.maternal_surname')],
			['data' => 'email', 'title' => __('users.email')],
			['data' => 'created_at', 'visible' => false, 'exportable' => true, 'title' => __('users.created_at')],
			['data' => 'updated_at', 'visible' => false, 'exportable' => false],
		];
		return array_merge($columns, $pColumns);
	}

	public function getActions($row)
	{
		$result = parent::getActions($row);
		if(auth()->user()->hasPermissions($this->routeResource.".permissions")) {
			$result .= '<a href="'.route($this->routeResource.".permissions", $row->id).'">
				<button type="button" class="btn btn-default" title='.__('users.permissions').'>
					<i class="fa fa-keyboard"></i>
				</button>
			</a>';
		}

		return $result;
	}
}
